<template>
    <DepartmentLayout title="Dashboard" :department="department">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                客戶服務管理
            </h2>
        </template>
        <a-button @click="createRecord">Add Faq</a-button>
        <a-table 
            :dataSource="faqs" 
            :columns="columns" 
            :rowKey=" record  => record.id"
            @change="handleTableChange"
        >
            <template #bodyCell="{column, text, record, index}" >
                <template v-if="column.dataIndex=='operation'">
                    <a-button @click="editRecord(record)">Edit</a-button>
                    <!-- <inertia-link :href="route('manage.department.faqs.show', {department:record.department_id, faq:record.id})">View</inertia-link> -->
                </template>
                <template v-else-if="column.dataIndex=='degree'">
                    {{ fields.degree.options.find(d=>d.value==record[column.dataIndex]).label }}
                </template>
                <template v-else-if="column.dataIndex=='subjects'">
                    <div v-html="gatherSubjectLables(text)"/>
                </template>
                <template v-else-if="column.dataIndex=='created_at'">
                    {{ formatDate(record[column.dataIndex]) }}
                </template>
                <template v-else-if="column.dataIndex=='updated_at'">
                    {{ formatDate(record[column.dataIndex]) }}
                </template>
                <template v-else>
                    {{record[column.dataIndex]}}
                </template>
            </template>
        </a-table>

        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%" >
        <a-form
            ref="modalRef"
            :model="modal.data"
            name="Teacher"
            layout="vertical"
            autocomplete="off"
            :rules="rules"
            :validate-messages="validateMessages"
        >
            <a-form-item label="Degree" name="degree" :rules="{required:true}">
                <a-select 
                    v-model:value="modal.data.degree" 
                    :options="fields.degree.options" 
                />
            </a-form-item>

            <a-form-item label="Subjects" name="subjects" :rules="{required:true}">
                <a-select 
                    mode="multiple"
                    v-model:value="modal.data.subjects" 
                    :options="fields.subjects.options" 
                />
            </a-form-item>
            <a-form-item label="Question" name="question_zh" :rules="{required:true}">
                <a-input v-model:value="modal.data.question_zh" />
            </a-form-item>
            <a-form-item label="Answer" name="answer_zh" :rules="{required:true}">
                <quill-editor v-model:value="modal.data.answer_zh" style="min-height:200px;" />
            </a-form-item>
        </a-form>
        <template #footer>
            <a-button v-if="modal.mode=='EDIT'" key="Update" type="primary"  @click="updateRecord()">Update</a-button>
            <a-button v-if="modal.mode=='CREATE'"  key="Store" type="primary" @click="storeRecord()">Add</a-button>
        </template>
    </a-modal>    
    <!-- Modal End-->
    </DepartmentLayout>

</template>

<script>
import DepartmentLayout from '@/Layouts/DepartmentLayout.vue';
import { quillEditor } from 'vue3-quill';
import dayjs from 'dayjs';

export default {
    components: {
        DepartmentLayout,
        quillEditor
    },
    props: ['department','faqs','fields'],
    data() {
        return {
            dateFormat:'YY-MM-DD HH:mm',
            modal:{
                isOpen:false,
                data:{},
                title:"Modal",
                mode:""
            },
            teacherStateLabels:{},
            columns:[
                {
                    title: 'Degree',
                    dataIndex: 'degree',
                    filters:this.fields.degree.options,
                    filterMultiple:false,
                    onFilter:(value,record)=>record.degree.includes(value)
                },{
                    title: 'Subjects',
                    dataIndex: 'subjects',
                    filters:this.fields.subjects.options,
                    filterMultiple:false,
                    onFilter:(value,record)=>record.subjects.includes(value)
                },{
                    title: 'Question',
                    dataIndex: 'question_zh',
                    sorter:{
                        compare:(a,b)=>a.question_zh.localeCompare(b.question_zh)
                    }
                },{
                    title: 'Created At',
                    dataIndex: 'created_at',
                },{
                    title: 'Updated At',
                    dataIndex: 'updated_at',
                },{
                    title: '操作',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules:{
                name_zh:{required:true},
                mobile:{required:true},
                state:{required:true},
            },
            validateMessages:{
                required: '${label} is required!',
                types: {
                    email: '${label} is not a valid email!',
                    number: '${label} is not a valid number!',
                },
                number: {
                    range: '${label} must be between ${min} and ${max}',
                },
            },
        }
    },
    created(){
        this.fields.degree.options.forEach(o=>o.text=o.label)
        this.fields.subjects.options.forEach(o=>o.text=o.label)
    },
    methods: {
        createRecord(){
            this.modal.data={};
            this.modal.data.department_id = this.department.id;
            this.modal.data.category_id=1;
            this.modal.mode="CREATE";
            this.modal.title="新增";
            this.modal.isOpen=true;
        },
        editRecord(record){
            console.log(record);
            this.modal.data={...record};
            console.log(this.modal.data.subjects);
            this.modal.data.subjects=this.modal.data.subjects;
            this.modal.mode="EDIT";
            this.modal.title="修改";
            this.modal.isOpen=true;
        },
        storeRecord(){
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.post(route('manage.enquiry.faqs.store',{department:this.department.id}),this.modal.data, {
                    onSuccess:(page)=>{
                        this.modal.data={};
                        this.modal.isOpen=false;
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });
            }).catch(err => {
                console.log(err);
            });
        },
        updateRecord(){
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.patch(route('manage.enquiry.faqs.update',{faq:this.modal.data.id}),this.modal.data, {
                    onSuccess:(page)=>{
                        this.modal.data={};
                        this.modal.isOpen=false;
                        console.log(page);
                    },
                    onError:(error)=>{
                        console.log(error);
                    }
                });
            }).catch(err => {
                console.log("error", err);
            });
        },
        gatherSubjectLables(items){
            return this.fields.subjects.options.reduce((a,c)=>{
                        if(items.includes(c.value)){
                            a+=c.label+"<br>"
                        }
                        return a
                    }, '') 

        },
        formatDate(date, format = 'YYYY-MM-DD HH:mm') {
            return dayjs(date).format(format);
        },
        handleTableChange(pag,filters,sorter){
            //console.log('params', pag, filters, sorter);

        },

    },
}
</script>