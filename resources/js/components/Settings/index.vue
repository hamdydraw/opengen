<template>
    <div class="">
        <div class="row" v-if="$gate.isAdmin()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Settings</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="updateRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        
                        <div class="col-12">
                            <label>Title </label> <span class="red">*</span>
                            <input v-model="form.title" type="text" name="title"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>
                          <div class="col-12 mt-3">
                            <label>Email </label> <span class="red">*</span>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="col-12 mt-3">
                            <label>Mobile </label> <span class="red">*</span>
                            <input v-model="form.mobile" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                            <has-error :form="form" field="mobile"></has-error>
                        </div>

                          <div class="col-12 mt-3">
                            <label>Countdown time (In minute) </label> <span class="red">*</span>
                            <input v-model="form.cda" type="text" name="cda"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('cda') }">
                            <has-error :form="form" field="cda"></has-error>
                        </div>

                          <div class="col-12 mt-3">
                            <label>Count time (In minute)  </label> <span class="red">*</span>
                            <input v-model="form.ct" type="text" name="ct"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('ct') }">
                            <has-error :form="form" field="ct"></has-error>
                        </div>


                         <div class="col-12 mt-3 mb-3">
                            <label>DMM system </label> <span class="red">*</span>
                            <input v-model="form.delivery" type="checkbox"  value="1" v-bind:true-value="1" v-bind:false-value="0" name="delivery"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('delivery') }">
                            <has-error :form="form" field="delivery"></has-error>
                        </div>



                    </div>
                      
 
            <div class="modal-footer"  v-if="form.id>0"> 
                <button type="submit"  class="btn btn-primary">Save</button>
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
        title () {  return 'Settings - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},     
          merchants:{},
          // Create a new form instance
          form: new Form({
              id:'',
              title: '',
              mobile:'',
              email:'',
              delivery:'',
              ct:'',
              cda:''
          })
          }
          },
         methods:{
             loadRecords()
             {
                this.$Progress.start(); 
                 axios.get("api/settings").then(
                   ({data})=>
                    {
                         this.form.fill(data);
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        }); 
             },   
             updateRecord()
             {
                this.$Progress.start() 
                this.form.put(this.$baseUrl+'api/updatesettings/'+this.form.id)
                .then(()=>{ 
                  Toast.fire({
                      type: 'success',
                      title: 'Settings updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
            
         } ,      
        created() {
          if(!this.$gate.isAdmin())
          this.$router.push('notfound');
          else{
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
     
</script>
