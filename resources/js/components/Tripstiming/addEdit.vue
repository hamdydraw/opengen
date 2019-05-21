<template>
    <div class="">
        <div class="row" v-if="$gate.isAdminOrMerchant()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new tripstiming</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-12">
                            <label>Timing </label> <span class="red">*</span>
                            <input v-model="form.timing" type="text" name="timing"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('timing') }">
                            <has-error :form="form" field="timing"></has-error>
                        </div>
                    </div> 
                   <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Details</label><span class="red">*</span>
                            <input v-model="form.details" type="text" name="details"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('details') }">
                            <has-error :form="form" field="details"></has-error>
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
        title () {  return 'Add tripstiming - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},    
          parentCats:{},
          // Create a new form instance
          form: new Form({
              id:'', 
              timing:'',
              details:'',
              merchant_id:''
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
                 axios.get(this.$baseUrl+"api/gettripstiming/"+this.$route.params.id).then(
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
                this.form.post(this.$baseUrl+'api/tripstiming')
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
                this.form.put(this.$baseUrl+'api/tripstiming/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'tripstiming updated successfully'
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
          if(!this.$gate.isAdminOrMerchant())
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
