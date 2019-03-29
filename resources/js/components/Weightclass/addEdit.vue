<template>
    <div class="">
        <div class="row" v-if="$gate.isAdminOrVendor()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new weight class</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-12">
                            <label>Title</label> <span class="red">*</span>
                            <input v-model="form.title" type="text" name="title"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>

                    </div>
                    <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Code</label> <span class="red">*</span>
                            <input v-model="form.code" type="text" name="code"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form="form" field="code"></has-error>
                        </div>

                    </div>
                    <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Value</label> <span class="red">*</span>
                            <input v-model="form.value" type="text" name="value"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('value') }">
                            <has-error :form="form" field="value"></has-error>
                        </div>

                    </div>
 
            <div class="modal-footer"> 
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>

              </div>
              <!-- /.card-body -->
              <div class="card-footer"> 
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      
        
    </div>
    
</template>

<script>
    export default {
        title () {  return 'Add weight class - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},    
          parentCats:{},
          // Create a new form instance
          form: new Form({
               id:'',
              title: '',
              language_id: '',
              weight_class_id:'',
              code:'',
              value:'0'
          })
          }
          },
         methods:{
           editRecords()
             {
               if(this.$route.params.id>0)
               {
                 this.editMode=true;
                  this.$Progress.start();  
                  console.log(this.$route.params.id);
                 axios.get(this.$baseUrl+"api/getWeightclass/"+this.$route.params.id).then(
                   ({data})=>
                    {
                    this.form.fill(data);
                    this.form.value=data.weightclass.value;
                    this.$Progress.finish();
                    }
                    );
               }
               else{
               this.editMode=false;}
                
             },
             loadRecords()
             {
                 
                this.$Progress.start(); 
                 axios.get(this.$baseUrl+"api/Weightclasslookups").then(
                   ({data})=>
                    {
                    this.parentCats=data;
                    console.log(this.parentCats);
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

             },
             updatePhoto(e){

             let file=e.target.files[0];
              let reader = new FileReader();
              if(file['size']<=2111152)
              {
              reader.readAsDataURL(file);
              reader.onload =   (file)=> {
                this.form.image=reader.result;
              }
              }
              else
              {
                      Swal.fire(
                        'Ooobs!',
                        'Your ara uploading a large file.',
                        'error'
                      )
              }
            
          },
             
             createRecord()
             {
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/weightclass')
                .then(()=>{
                  Fire.$emit('AfterCreate');  
                  Toast.fire({
                      type: 'success',
                      title: 'Record created successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                   
                }); 
             },
             updateRecord()
             {
                this.$Progress.start() 
                this.form.put(this.$baseUrl+'api/weightclass/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'weightclass updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
               getPhoto(){
               let photo=this.form.image?(this.form.image.length>100)?this.form.image:this.$baseUrl+"img/uploads/"+this.form.image:'';
               return photo;
             }
         } ,      
        created() {
          if(!this.$gate.isAdminOrVendor())
          this.$router.push('notfound');
          else{
           this.editRecords();
           this.loadRecords();
          
           Fire.$on('AfterCreate',()=>{
              
             });
              Fire.$on('searching',()=>{
                this.$Progress.start() 
                let query=this.$parent.search;
                   axios.get("api/findUser?q="+query).then(
                   ({data})=>
                    {
                    this.records=data;
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

                });
          }
        }
    }
      $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    ClassicEditor
      .create(document.querySelector('#editor1'))
      .then(function (editor) {
        // The editor instance
      })
      .catch(function (error) {
        console.error(error)
      }) 
  })
</script>
