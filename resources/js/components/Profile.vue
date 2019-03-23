<style>
.widget-user-header
{
  background-position: center center;
  background-size: cover;
  height: 250px!important;
}
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background: url('./img/profile.jpg') center center;">
                <h3 class="widget-user-username">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="getPhoto()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            </div>
            <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                   
                  <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
             

                  <div class="tab-pane active" id="settings">
                    
                      <form class="form-horizontal" @submit.prevent="updateProfile" @keydown="form.onKeydown($event)">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input type="texs"  v-model="form.name"  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" id="inputName" placeholder="Name">
                           <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input type="email"  v-model="form.email"  class="form-control"  :class="{ 'is-invalid': form.errors.has('email') }" id="inputEmail" placeholder="Email">
                           <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>

                        <div class="col-sm-10">
                          <input type="password"  v-model="form.password"  class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" id="password" placeholder="password">
                           <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                       <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Photo</label>

                        <div class="col-sm-10">
                          <input type="file"   @change="updatePhoto"  class="form-control" id="photo" placeholder="photo">
                        </div>
                      </div>
                     
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
           form: new Form({
                        id:'',
                        name: '',
                        email: '',
                        photo:'',
                        password: '',
                    })
        }},
        mounted() {
            console.log('Component mounted.')
        },
        created(){
              this.$Progress.start(); 
                 axios.get("api/profile").then(
                   ({data})=>
                    {
                    this.form.fill(data);
                    this.$Progress.finish();
                    }
                    );
        },
        methods:{
          updatePhoto(e){

             let file=e.target.files[0];
              let reader = new FileReader();
              if(file['size']<=2111152)
              {
              reader.readAsDataURL(file);
              reader.onload =   (file)=> {
                this.form.photo=reader.result;
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
          updateProfile()
             {
                this.$Progress.start() 
                this.form.put('api/profile')
                .then(()=>{
                    
                  Toast.fire({
                      type: 'success',
                      title: 'Profile updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
             getPhoto(){

               return "img/profile/"+this.form.photo;
             }
        }
    }
</script>
