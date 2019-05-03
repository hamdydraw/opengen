<template>
    <div class="">
        <div class="row" v-if="$gate.isMerchant()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new Attribute</h3> 
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
                          <label>Attribute group</label> <span class="red">*</span>
                          <select v-model="form.attribute_group_id"   class="form-control" :class="{ 'is-invalid': form.errors.has('attribute_group_id') }">
                          <option value="" selected> Please select</option>
                            <option v-for="n in groups" :key="n.id" :value="n.id">{{n.name_ar}}</option>
                          </select>
                          <has-error :form="form" field="attribute_group_id"></has-error>
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
        title () {  return 'Add attribute - '+this.$appName;},
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
              attribute_group_id:'',
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
                 axios.get(this.$baseUrl+"api/getattribute/"+this.$route.params.id).then(
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
             createRecord()
             {
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/attribute')
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
                this.form.put(this.$baseUrl+'api/attribute/'+this.$route.params.id)
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
             getzones(){

             },    
          loadRecords()
             {
                 
                this.$Progress.start(); 
                 axios.get(this.$baseUrl+"api/attributelookups").then(
                   ({data})=>
                    {
                    this.groups=data; 
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

             }
         } ,  
        created() {
          if(!this.$gate.isMerchant())
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
