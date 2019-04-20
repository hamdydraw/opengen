<template>
    <div class="">
        <div class="row" v-if="$gate.isAdminOrVendor()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new currency</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-12">
                            <label>Title </label> <span class="red">*</span>
                            <input v-model="form.title" type="text" name="title"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>
                    </div> 
                   <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Code</label><span class="red">*</span>
                            <input v-model="form.code" type="text" name="code"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form="form" field="code"></has-error>
                        </div>
                    </div> 
                    <div class="row mt-2"> 
                        <div class="col-6">
                            <label>Symbol left</label>
                            <input v-model="form.symbol_left" type="text" name="symbol_left"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('symbol_left') }">
                            <has-error :form="form" field="symbol_left"></has-error>
                        </div>
                        <div class="col-6">
                            <label>Symbol right</label>
                            <input v-model="form.symbol_right" type="text" name="symbol_right"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('symbol_right') }">
                            <has-error :form="form" field="symbol_right"></has-error>
                        </div>
                    </div> 
                     <div class="row mt-2"> 
                        <div class="col-6">
                            <label>Decimal place</label>
                            <input v-model="form.decimal_place" type="text" name="decimal_place"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('decimal_place') }">
                            <has-error :form="form" field="decimal_place"></has-error>
                        </div>
                        <div class="col-6">
                            <label>Value  </label>
                            <input v-model="form.value" type="text" name="value"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('value') }">
                            <has-error :form="form" field="value"></has-error>
                        </div>
                    </div> 
                    <div class="row mt-2"> 
                        <div class="col-6">
                            <label>Status</label> 
                            <select v-model="form.status"  class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                            <option value="1" selected >Enabled</option>
                            <option value="2">Disabled</option> 
                            </select>
                            <has-error :form="form" field="status"></has-error>
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
        title () {  return 'Add currency - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},    
          parentCats:{},
          // Create a new form instance
          form: new Form({
              id:'', 
              title:'',
              code:'',
              symbol_left:'',
              symbol_right:'',
              decimal_place:'',
              value:'',
              status :'1'
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
                 axios.get(this.$baseUrl+"api/getCurrency/"+this.$route.params.id).then(
                   ({data})=>
                    {
                    this.form.fill(data); 
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
                this.form.post(this.$baseUrl+'api/currency')
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
                this.form.put(this.$baseUrl+'api/currency/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'currency updated successfully'
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
     
</script>
