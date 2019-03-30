<template>
    <div class="">
        <div class="row" v-if="$gate.isAdminOrVendor()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new taxrate</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-12">
                            <label>Name </label> <span class="red">*</span>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                    </div> 
                   <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Rate</label><span class="red">*</span>
                            <input v-model="form.rate" type="text" name="rate"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('rate') }">
                            <has-error :form="form" field="rate"></has-error>
                        </div>
                    </div> 
                    <div class="row mt-2"> 
                     
                         <div class="col-6">
                            <label>Type</label> 
                            <select v-model="form.type"  class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="1" selected >Fixed Amount	</option>
                            <option value="2">Percentage</option> 
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                    </div> 
                      
                     
                    <div class="modal-footer mt-2"> 
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
        title () {  return 'Add taxrate - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},    
          parentCats:{},
          // Create a new form instance
          form: new Form({
              id:'', 
              name:'',
              rate:'',
              type:''
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
                 axios.get(this.$baseUrl+"api/getTaxrate/"+this.$route.params.id).then(
                   ({data})=>
                    {
                    this.form.fill(data); 
                    this.$Progress.finish();
                    }
                    );
               }
               else{
               this.editMode=false;}
                
             } ,
             
             createRecord()
             {
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/taxrate')
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
                this.form.put(this.$baseUrl+'api/taxrate/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'taxrate updated successfully'
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
