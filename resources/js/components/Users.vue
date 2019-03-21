<template>
    <div class="container">
       
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All users</h3>

                <div class="card-tools">
                   <button class="btn btn-success" data-toggle="modal" data-target="#addnew">Add new user <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th> 
                    <th>Register at</th> 
                    <th>Actions</th>
                  </tr>
                 
                  <tr  v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                   <td>{{user.name | upText}}</td>
                   <td>{{user.email}}</td> 
                   <td>{{user.created_at | todata}}</td> 
                    <td>
                    <a href="#">
                      <i class="fa fa-edit text-blue"></i>
                       
                    </a>
                     <a href="#">
                      <i class="fa fa-trash text-red"></i>
                       
                    </a>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
       <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnew" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addnewLabel">Add new</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="createUser" @keydown="form.onKeydown($event)">
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
         data () {
                    return {
                    users:{},    
                    // Create a new form instance
                    form: new Form({
                        name: '',
                        email: '',
                        password: '',
                    })
                    }
                },
         methods:{
             loadUsers()
             {
                this.$Progress.start(); 
                 axios.get("api/user").then(({data})=> (this.users=data.data));
                   this.$Progress.finish()

             },
             createUser()
             {
                this.$Progress.start() 
                this.form.post('api/user');
                $("#addnew").modal('hide');
                this.loadUsers();
                Toast.fire({
                    type: 'success',
                    title: 'User created successfully'
                  })
                    this.$Progress.finish()

             }
         } ,      
        created() {
           this.loadUsers();
        }
    }
</script>
