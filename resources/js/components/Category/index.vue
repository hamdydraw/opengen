<template>

    <div class="">
        
        <div class="row" v-if="$gate.isAdminOrVendor()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3> 
                <div class="card-tools"> 
                   <router-link class="btn btn-success"  to="/category/addEdit"><i class="fas fa-plus-circle"></i> Add Category</router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th> 
                    <th>Sort order</th> 
                    <th>Actions</th>
                  </tr> 
                  <tr  v-for="record in records.data" :key="record.category_id">
                    <td>{{record.category_id}}</td>
                   <td>{{record.name | upText}}</td> 
                   <td>{{record.category.sort_order}}</td> 
                    <td> 
                    <router-link  :to="{ name: 'categoryaddEdit', params: { id: record.category_id}}"><i class="fa fa-edit blue"></i></router-link>
                    / 
                     <a href="#" @click="deleteRecord(record.categort_id)">
                      <i class="fa fa-trash red"></i>
                       
                    </a>
                    </td>
                  </tr>
                </tbody></table>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="records" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
       <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnew" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addnewLabel">{{ editMode?"Edit User":"Add new"}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode?updateUser():createUser()" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                    <div class="form-group">
                    <label>Name</label>
                    <input v-model="form.name" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                    <label>Email</label>
                    <input v-model="form.email" type="email" name="email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                    </div>

                     <div class="form-group">
                    <label>User type</label>
                    
                    <select v-model="form.type"  class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                      <option value="admin">admin</option>
                      <option value="vendor">vendor</option> 
                    </select>
                    <has-error :form="form" field="email"></has-error>
                    </div>


                    <div class="form-group">
                    <label>Password</label>
                    <input v-model="form.password" type="password" name="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                    </div>
                    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
            </div>
        </div>
        </div>
        
    </div>
    
</template>

<script>
    export default {
         title () {  return 'Categories - '+this.$appName;},
         data () {
          return {
          editMode:true,  
          
          records:{},    
          // Create a new form instance
          form: new Form({
              id:'',
              name: '',
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
             loadRecords()
             {
                this.$Progress.start(); 
                 axios.get("api/category").then(
                   ({data})=>
                    {
                    this.records=data;
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

             },
             getResults(page = 1) {
               this.$Progress.start(); 
                axios.get('api/category?page=' + page)
                  .then(response => {
                    this.records = response.data;
                    this.$Progress.finish();
                  });
              },
             deleteRecord(userId)
             {
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      if (result.value) {
                             this.form.delete('api/user/'+userId).then(()=>{ 
                              Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                              )
                              Fire.$emit('AfterCreate');
                            
                        }).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                        });
                      }
                  })
             },
             createUser()
             {
                this.$Progress.start() 
                this.form.post('api/user')
                .then(()=>{
                  Fire.$emit('AfterCreate');
                  $("#addnew").modal('hide'); 
                  Toast.fire({
                      type: 'success',
                      title: 'User created successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                   
                }); 
             },
             updateUser()
             {
                this.$Progress.start() 
                this.form.put('api/user/'+this.form.id)
                .then(()=>{
                  Fire.$emit('AfterCreate');
                  $("#addnew").modal('hide'); 
                  Toast.fire({
                      type: 'success',
                      title: 'User updated successfully'
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
           this.loadRecords();
           Fire.$on('AfterCreate',()=>{
             this.loadRecords();
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
</script>
