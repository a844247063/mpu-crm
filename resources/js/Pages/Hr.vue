    <template>
    <div class="p-5 bg-gray-200">
        <a href="/">
            <img src="/images/mpu_banner.png" width="300" />
        </a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

    


                   </div>
        </div>
    </div>
    <a-form :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit">
    <a-form-item label="Name">
      <a-input v-decorator="['note', { rules: [{ required: true, message: 'Please input your note!' }] }]"/>
    </a-form-item>
    <a-form-item label="Type">
      <a-select 
        v-decorator="['gender', { rules: [{ required: true, message: 'Please select your gender!' }] }]" 
        placeholder="Select a option and change input text above" 
        @change="handleSelectChange"
      >
        <a-select-option value="Onboarding">Onboarding</a-select-option>
        <a-select-option value="Resign">Resign</a-select-option>
        <a-select-option value="promotion">promotion</a-select-option>
        <a-select-option value="Transfer_department">Transfer_department</a-select-option>
   
      </a-select>
    </a-form-item>
    <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
      <a-button type="primary" html-type="submit">Submit</a-button>
    </a-form-item>
  </a-form>
             

                 

</template>

<script>


</script>

