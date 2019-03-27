<template>
    <div class="">
        <div class="row" v-if="$gate.isAdminOrVendor()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new category</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row">

                         

                        <div class="col-12">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                    </div>

                    <div class="row mt-2">

                        <div class="col-6">
                        <label>Parent</label> 
                        <select v-model="form.parent_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('parent_id') }">
                        <option value="" selected> Please select</option>
                           <option v-for="n in parentCats" :key="n.category_id" :value="n.category_id">{{n.name}}</option>

                        </select>
                        <has-error :form="form" field="parent_id"></has-error>
                        </div>

                        <div class="col-6">
                            <label>Status</label> 
                            <select v-model="form.status"  class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                            <option value="1">Enabled</option>
                            <option value="2">Disabled</option> 
                            </select>
                            <has-error :form="form" field="status"></has-error>
                        </div>

                   </div>  
                <div class="row mt-2">

                    <div class="col-6">
                    <label>image</label>
                    
                   <input type="file"   @change="updatePhoto"  class="form-control" id="photo" placeholder="photo">
                    <has-error :form="form" field="parent_id"></has-error>
                    </div>

                    <div class="col-6">
                        <label>Sort order</label> 
                         <input v-model="form.sort_order" type="text" name="sort_order"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('sort_order') }">
                            <has-error :form="form" field="sort_order"></has-error>
                        <has-error :form="form" field="sort_order"></has-error>
                    </div>

             </div> 
              <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Description</label> 
                            <textarea id="editor" v-bind="form.description" name="editor1" style="width: 100%"></textarea>
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
        title () {  return 'Add category - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},    
          parentCats:{},
          // Create a new form instance
          form: new Form({
              id:'',
              name: '',
              parent_id:'',
              language_id: '',
              description:'',
              meta_title:'',
              meta_description: '',
              meta_keyword:'',
              image:'',
              top:'',
              sort_order:'',
              status:''
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
                 axios.get(this.$baseUrl+"api/getCategory/"+this.$route.params.id).then(
                   ({data})=>
                    {
                    this.form.fill(data);
                    this.form.status=data.category.status;
                    this.form.sort_order=data.category.sort_order;
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
                 axios.get(this.$baseUrl+"api/categorylookups").then(
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
            newModal(){
              this.editMode=false;
              this.form.reset();
              $("#addnew").modal('show'); 
            },
              editModal(user){
               this.editMode=true;
              this.form.fill(user);
              $("#addnew").modal('show'); 
            }, 
             createRecord()
             {
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/category')
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
                this.form.put(this.$baseUrl+'api/category/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'Category updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
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
