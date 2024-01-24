<template>
    <div class="p-5 bg-gray-200">
      <a href="/">
        <img src="/images/mpu_banner.png" width="300" />
      </a>
    </div>      
    <div class="py-12">
        <div class="sm:px-8 lg:px-10 mx-auto" style="max-width: 800px;">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <a-form
            :model="formState"
            v-bind="layout"
            name="nest-messages"
            :validate-messages="validateMessages"
            @finish="onFinish"
          >
            <a-form-item :name="[ 'name']" label="Name" :rules="[{ required: true }]">
              <a-input v-model:value="formState.name" />
            </a-form-item>
  
            <a-form-item
              name="select"
              label="Select"
              has-feedback
              :rules="[{ required: true, message: 'Please select your type!' }]"
            >
              <a-select v-model:value="formState.select" placeholder="Please select a type">
                <a-select-option value="Onboarding">Onboarding</a-select-option>
                <a-select-option value="Resign">Resign</a-select-option>
                <a-select-option value="promotion">promotion</a-select-option>
              </a-select>
            </a-form-item>
  
            <a-form-item name="date-picker" label="DatePicker" :rules="[{ required: true }]">
              <a-date-picker v-model:value="formState['date-picker']" value-format="YYYY-MM-DD" @change="updateLastDay" />
            </a-form-item>
  
            <a-form-item v-if="formState['date-picker']" label="Last Day">
  <a-input :value="getLastDay()" disabled />
</a-form-item>
  
            <a-form-item :name="[ 'email']" label="Email" :rules="[{ required: true, type: 'email' }]">
              <a-input v-model:value="formState.email" />
            </a-form-item>
  
            <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
              <a-button type="primary" html-type="submit">Submit</a-button>
            </a-form-item>      
          </a-form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent, reactive } from 'vue';
  
  export default defineComponent({
    setup() {
      const layout = {
        labelCol: {
          span: 8,
        },
        wrapperCol: {
          span: 16,
        },
      };
  
      const validateMessages = {
        required: '${label} is required!',
        types: {
          email: '${label} is not a valid email!',
        },
      };
  
      const formState = reactive({
      
          name: '',
          email: '',
          lastDay:'',
    
      });
  
      const onFinish = values => {
        values.lastDay = getLastDay();
        console.log('Success:', values);
      };
  
      const updateLastDay = () => {
  const chosenDate = new Date(formState['date-picker']);
  const lastDay = new Date(chosenDate.getTime() + 30 * 24 * 60 * 60 * 1000); // 30 days later
  formState.lastDay = lastDay.toISOString().split('T')[0];
};

const getLastDay = () => {
  return formState.lastDay || '';
};
  
      return {
        formState,
        onFinish,
        layout,
        validateMessages,
        getLastDay,
        updateLastDay,
      };
    },
  });
  </script>