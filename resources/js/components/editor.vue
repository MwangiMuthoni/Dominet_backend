<template>
    <div id="app">
        <vue2-tinymce-editor v-model="content" :width:="500" :height="900" :options="options" ></vue2-tinymce-editor>
    </div>
</template>


<script>
    import Network from "../network-class";
    export default {
      name:'editor',
      props: {
          prefill:{type: String,required: false},
          height:{type: String,required: false},
              },
        created(){
            if(this.prefill!=null){this.content=this.prefill;}
        },
        mounted(){
        },
        destroyed () {
        },
        data:() => ({
            content: '',
            options:{
                    paste_webkit_styles: 'color font-size',
                    paste_data_images: false,
                    content_css: "/css/app.css",
                    menubar:false,
                    plugins: 'advlist lists autolink charmap code codesample directionality emoticons',
                    toolbar1:'fontselect | fontsizeselect | formatselect | bold italic underline strikethrough forecolor backcolor',
                    toolbar2:'alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link table removeformat code',
                  },
        }),
        methods: { 
          
        },
        watch: {
            content(newContent) {
              this.$emit('input', newContent);
            },
          },
    }
</script>