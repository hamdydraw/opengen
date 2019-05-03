<template>
    <div class="">
        <div class="row" v-if="$gate.isMerchant()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new group</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-6">
                            <label>Name arabic </label> <span class="red">*</span>
                            <input v-model="form.name_ar" type="text" name="name_ar"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name_ar') }">
                            <has-error :form="form" field="name_ar"></has-error>
                        </div>
                        <div class="col-6">
                            <label>Name english </label> 
                            <input v-model="form.name_en" type="text" name="name_en"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name_en') }">
                            <has-error :form="form" field="name_en"></has-error>
                        </div>
                        
                        
                         <div class="col-6">
                            <label>Sort order </label> <span class="red">*</span>
                            <input v-model="form.sort_order" type="text" name="sort_order"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('sort_order') }">
                            <has-error :form="form" field="sort_order"></has-error>
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
        title () {  return 'Add attribute group - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          groups:{},
          records:{},     
          merchants:{},
          // Create a new form instance
          form: new Form({
              id:'',
              name_ar: '',
              name_en:'',
              sort_order:''
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
                 axios.get(this.$baseUrl+"api/getattributegroup/"+this.$route.params.id).then(
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
             createRecord()
             {
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/attributegroups')
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
                this.form.put(this.$baseUrl+'api/attributegroups/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'Attribute updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
                 
           
         } ,  
        created() {
          if(!this.$gate.isMerchant())
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
