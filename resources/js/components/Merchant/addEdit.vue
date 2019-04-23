<template>
    <div class="">
        <div class="row" v-if="$gate.isAdminOrMerchant()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new merchant</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-6">
                            <label>Name arabic</label> <span class="red">*</span>
                            <input v-model="form.name_ar" type="text" name="name_ar"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name_ar') }">
                            <has-error :form="form" field="name_ar"></has-error>
                        </div>
                        <div class="col-6">
                            <label>Name english</label> 
                            <input v-model="form.name_en" type="text" name="name_en"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name_en') }">
                            <has-error :form="form" field="name_en"></has-error>
                        </div>
                    </div>

                    <div class="row mt-2">

                        <div class="col-6">
                        <label>Merchant type</label> <span class="red">*</span>
                        <select v-model="form.merchant_type_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('merchant_type_id') }">
                        <option value="" selected> Please select</option>
                           <option v-for="n in merchanttypes" :key="n.id" :value="n.id">{{n.name_ar}}</option>

                        </select>
                        <has-error :form="form" field="merchant_type_id"></has-error>
                        </div>
                        <div class="col-6">
                        <label>Country  </label> <span class="red">*</span>
                        <select v-model="form.country_id" v-on:change="getzones"  class="form-control" :class="{ 'is-invalid': form.errors.has('country_id') }">
                        <option value="" selected> Please select</option>
                           <option v-for="n in countries" :key="n.id" :value="n.id">{{n.name_ar}}</option>

                        </select>
                        <has-error :form="form" field="country_id"></has-error>
                        </div>
                        <div class="col-6">
                        <label>Zone  </label> <span class="red">*</span>
                        <select v-model="form.city_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('city_id') }">
                        <option value="" selected> Please select</option>
                           <option v-for="n in zones" :key="n.id" :value="n.id">{{n.name_ar}}</option>

                        </select>
                        <has-error :form="form" field="city_id"></has-error>
                        </div>
                         <div class="col-6">
                            <label>Location</label>
                            <input v-model="form.location" type="text" name="location"
                                class="form-control">
                            
                        </div>
                          <div class="col-6">
                            <label>Mobile type  </label> <span class="red">*</span>
                            <select v-model="form.mobile_type_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('mobile_type_id') }">
                            <option value="" selected> Please select</option>
                              <option v-for="n in mobiletypes" :key="n.id" :value="n.id">{{n.name_ar}}</option>

                            </select>
                            <has-error :form="form" field="mobile_type_id"></has-error>
                        </div>
                              <div class="col-6">
                            <label>Mobile</label> <span class="red">*</span>
                            <input v-model="form.mobile" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                <has-error :form="form" field="span"></has-error>
                            
                        </div>
                        <div class="col-6 mt-4">
                            
                          <input type="checkbox" id="haveSW" value="1" class="checkbox" v-model="form.haveSW">
                            <label>Have Softwate</label> 
                            
                        </div>
                         <div class="col-6 mt-4">
                            
                          <input type="checkbox" id="haveHW" value="1" class="checkbox" v-model="form.haveHW">
                            <label>Have Softwate</label> 
                            
                        </div>
  
                   </div>  
                <div class="row mt-2"> 
                    <div class="col-4">
                    <label>Photo</label>
                    
                   <input type="file"   @change="updatePhoto"  class="form-control" id="photo" placeholder="photo">
                
                    <has-error :form="form" field="photo"></has-error>
                    </div>
                    <div class="col-2"> 
                    <img class="img-circle" width="100" :src="getPhoto()" alt="Image"> 
                    </div>
                    <div class="col-4">
                    <label>Owner photo</label>
                    
                   <input type="file"   @change="updateOwenerPhoto"  class="form-control" id="owner_photo" placeholder="owner_photo">
                
                    <has-error :form="form" field="owner_photo"></has-error>
                    </div>
                    <div class="col-2"> 
                    <img class="img-circle" width="100" :src="getOwnerPhoto()" alt="Image"> 
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
        title () {  return 'Add merchant - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},    
          merchanttypes:{},
           countries:{},
           mobiletypes:{},
            zones:{},
          // Create a new form instance
          form: new Form({
              id:'',
              name_ar: '',
              name_en: '',
              merchant_type_id:'',
              city_id:'',
              country_id: '',
              location:'',
              photo:'',
              owner_photo:'',
              mobile:'',
              mobile_type_id:'',
              haveHW:'',
              haveSW:''
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
                 axios.get(this.$baseUrl+"api/getmerchant/"+this.$route.params.id).then(
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
             loadRecords()
             {
                 
                this.$Progress.start(); 
                 axios.get(this.$baseUrl+"api/merchantlookups").then(
                   ({data})=>
                    {
                        this.merchanttypes=data.merchanttypes;
                        this.countries=data.countries;
                        this.mobiletypes=data.mobiletypes;
                        console.log(this.merchanttypes);
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
              updateOwenerPhoto(e){

             let file=e.target.files[0];
              let reader = new FileReader();
              if(file['size']<=2111152)
              {
              reader.readAsDataURL(file);
              reader.onload =   (file)=> {
                this.form.owner_photo=reader.result;
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
                this.form.post(this.$baseUrl+'api/merchant')
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
                this.form.put(this.$baseUrl+'api/merchant/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'merchant updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
             getzones(){

             }, getzones(){
                
            this.$Progress.start(); 
             axios.get(this.$baseUrl+"api/getzones/"+this.form.country_id).then(
                   ({data})=>
                    { 
                        this.zones=data;
                        
                        this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });

                        
            
             },
               getPhoto(){
               let photo=this.form.photo?(this.form.photo.length>100)?this.form.photo:this.$baseUrl+"img/merchant/"+this.form.photo:'';
               return photo;
             },
              getOwnerPhoto(){
               let photo=this.form.owner_photo?(this.form.owner_photo.length>100)?this.form.owner_photo:this.$baseUrl+"img/merchant/"+this.form.owner_photo:'';
               return photo;
             }
         } ,      
        created() {
          if(!this.$gate.isAdminOrMerchant())
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
