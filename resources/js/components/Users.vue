<template>
    <div class="">
       
        <div class="row" v-if="$gate.isAdminOrMerchant()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All users</h3>

                <div class="card-tools">
                   <button class="btn btn-success" @click="newModal()">Add new user <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th> 
                    <th>Type</th> 
                    <th>Register at</th> 
                    <th>Actions</th>
                  </tr>
                 
                  <tr  v-for="user in users.data" :key="user.id">
                    <td>{{user.id}}</td>
                   <td>{{user.name | upText}}</td>
                   <td>{{user.email}}</td> 
                   <td>{{user.type}}</td> 
                   <td>{{user.created_at | todata}}</td> 
                    <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                       
                    </a> / 
                     <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                       
                    </a>
                    </td>
                  </tr>
                </tbody></table>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
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
                        <option value="merchant">merchant</option> 
                        <option value="enduser">enduser</option> 
                        <option value="pilot">pilot</option>
                        <option value="dmm">dmm</option>  
                      </select>
                      <has-error :form="form" field="email"></has-error>
                    </div>

                      <div class="form-group" v-if="form.type=='merchant'">
                      <label>Merchant</label> 
                      <select v-model="form.userable_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('userable_id') }">
                      <option value="" selected> Please select</option>
                          <option v-for="n in merchants" :key="n.id" :value="n.id">{{n.name_ar}}</option>

                      </select>
                      <has-error :form="form" field="userable_id"></has-error>
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
         title () {  return 'Users - '+this.$appName;},
         data () {
          return {
          editMode:true,   
          users:{},    
          merchants:{},
          // Create a new form instance
          form: new Form({
              id:'',
              name: '',
              email: '',
              type:'',
              photo:'',
              password: '',
              userable_id:'',
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
             loadUsers()
             {
                this.$Progress.start(); 
                 axios.get("api/user").then(
                   ({data})=>
                    {
                    this.users=data;
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

             },
             getResults(page = 1) {
               this.$Progress.start(); 
                axios.get('api/user?page=' + page)
                  .then(response => {
                    this.users = response.data;
                    this.$Progress.finish();
                  });
              },
             deleteUser(userId)
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
             },
             loadRecords()
             {
                 
                this.$Progress.start(); 
                 axios.get(this.$baseUrl+"api/userslookups").then(
                   ({data})=>
                    {
                        this.merchants=data.merchants; 
                        this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

             }
         } ,      
        created() {
          if(!this.$gate.isAdminOrMerchant())
          this.$router.push('notfound');
          else{
           this.loadUsers();
           this.loadRecords();
           Fire.$on('AfterCreate',()=>{
             this.loadUsers();
             });
              Fire.$on('searching',()=>{
                this.$Progress.start() 
                let query=this.$parent.search;
                   axios.get("api/findUser?q="+query).then(
                   ({data})=>
                    {
                    this.users=data;
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
