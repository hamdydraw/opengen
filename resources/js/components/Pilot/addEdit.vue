<template>
    <div class="">
        <div class="row" v-if="$gate.isAdmin()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new pilot</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-6">
                            <label>Name </label> <span class="red">*</span>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                         <div class="col-6">
                            <label>Mobile</label> <span class="red">*</span>
                            <input v-model="form.mobile" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                <has-error :form="form" field="span"></has-error> 
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-6">
                        <label>Merchant</label> 
                        <select v-model="form.merchant_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('merchant_id') }">
                        <option value="" selected> Please select</option>
                            <option v-for="n in merchants" :key="n.id" :value="n.id">{{n.name_ar}}</option>

                        </select>
                        <has-error :form="form" field="merchant_id"></has-error>
                        </div>

                        <div class="col-4">
                        <label>Photo</label>
                        
                      <input type="file"   @change="updatePhoto"  class="form-control" id="photo" placeholder="photo">
                    
                        <has-error :form="form" field="photo"></has-error>
                        </div>
                        <div class="col-2"> 
                        <img class="img-circle" width="100" :src="getPhoto()" alt="Image"> 
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
        title () {  return 'Add pilot - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},     
          merchants:{},
          // Create a new form instance
          form: new Form({
              id:'',
              name: '',
              merchant_id:'', 
              photo:'', 
              mobile:'', 
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
                 axios.get(this.$baseUrl+"api/getpilot/"+this.$route.params.id).then(
                   ({data})=>
                    {
                    this.form.fill(data);
                    this.getzones(this.form.country_id);
                    this.$Progress.finish();
                    }
                    );
               }
               else{
               this.editMode=false;}
                
             },
             
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
               
             
             createRecord()
             {
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/pilot')
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
                this.form.put(this.$baseUrl+'api/pilot/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'Pilot updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
             getzones(){

             }, 
               getPhoto(){
               let photo=this.form.photo?(this.form.photo.length>100)?this.form.photo:this.$baseUrl+"img/pilot/"+this.form.photo:'';
               return photo;
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
          if(!this.$gate.isAdmin())
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
     
</script>
