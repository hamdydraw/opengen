<template>
    <div class="">
        <div class="row" v-if="$gate.isMerchant()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">In/out inventory</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="updateRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-6">
                            <label>Product barecode </label> <span class="red">*</span>
                            <input v-model="form.code"  @keyup="searchBarcode"   type="text" name="code"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form="form" field="code"></has-error>
                        </div>
                        <div class="col-6">
                            <label>Quantity </label> <span class="red">*</span>
                            <input v-model="form.quantity" type="text" name="quantity"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                            <has-error :form="form" field="quantity"></has-error>
                        </div>
                    </div>
                      <div class="row mb-4 mt-4" v-if="form.id>0"> 
                        <div class="col-6">
                            <label>Product name </label> 
                            <input v-model="form.name_ar" readonly type="text" name="name_ar" class="form-control" >
                        </div>
                        <div class="col-6">
                            <label>Product price </label> 
                            <input v-model="form.price" readonly type="text" name="price" class="form-control" >
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
        title () {  return 'In/Out inventory - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},     
          merchants:{},
          // Create a new form instance
          form: new Form({
              id:'',
              code: '',
              quantity:'',
              price:'',
              name_ar:''
          })
          }
          },
         methods:{
           
              
             updateRecord()
             {
                this.$Progress.start() 
                this.form.put(this.$baseUrl+'api/updatequantity/'+this.form.id)
                .then(()=>{ 
                  Toast.fire({
                      type: 'success',
                      title: 'Inventory updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
             searchBarcode(){
                  setTimeout(() => {
                    this.$Progress.start() 
                    let query=this.form.code;
                   axios.get("api/findProduct?q="+query).then(
                   ({data})=>
                    {
                      this.form= new Form({ id:'', code: '',price:'', quantity:'', name_ar:'' });
                      if(data!=null){
                    this.form.id=data.id;
                   this.form.quantity=data.quantity;
                   this.form.code=data.code
                   this.form.price=data.price;
                   this.form.name_ar=data.name_ar;
                    }
                    else
                    {
                      this.form= new Form({ id:'', code: '',price:'', quantity:'', name_ar:'' });
                    }
                    
                     this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   
                  }, 1000);
              }
         } ,      
        created() {
          if(!this.$gate.isMerchant())
          this.$router.push('notfound');
          else{
           
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
