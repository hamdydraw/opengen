<template> 
    <div class="">  
        <div class="row" v-if="$gate.isAdmin()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products</h3> 
                <div class="card-tools"> 
                   <router-link class="btn btn-success"  to="/product/addEdit"><i class="fas fa-plus-circle"></i> Add product</router-link>
                </div>
              </div> 
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                  
                    <th v-text="$ml.get('name')">   </th> 
                    <th v-text="$ml.get('code')">  </th> 
                    <th v-text="$ml.get('model')">  </th> 
                    <th v-text="$ml.get('quantity')">  </th> 
                    <th v-text="$ml.get('image')">  </th> 
                    <th v-text="$ml.get('actions')">  </th>
                  </tr> 
                  <tr  v-for="record in records.data" :key="record.id">
                   
                   <td>{{record.name_ar | upText}}</td> 
                   <td>{{record.code}}</td> 
                   <td>{{record.model}}</td> 
                   <td>{{record.quantity}}</td> 
                   <td><img class="img-circle" width="40" height="40" :src="getPhoto(record.photo)" alt="Image"> </td> 
                    <td> 
                    <router-link  :to="{ name: 'productaddEdit', params: { id: record.id}}"><i class="fa fa-edit blue"></i></router-link>
                    / 
                     <a href="#" @click="deleteRecord(record.id)">
                      <i class="fa fa-trash red"></i>
                       
                    </a>
                    </td>
                  </tr>
                </tbody></table>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="records" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
       
        
    </div>
    
</template>

<script>
    export default {
         title () {  return 'Products - '+this.$appName;},
         data () {
          return {
          editMode:true,   
          records:{},    
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
              getPhoto(product_photo){
               let photo=product_photo?(this.form.photo.length>100)?product_photo:this.$baseUrl+"img/product/"+product_photo:this.$baseUrl+"img/no_image.jpg";
               return photo;
             },
             loadRecords()
             {
                this.$Progress.start(); 
                 axios.get("api/product").then(
                   ({data})=>
                    {
                    this.records=data;
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        }); 
             },
             getResults(page = 1) {
               this.$Progress.start(); 
                axios.get('api/product?page=' + page)
                  .then(response => {
                    this.records = response.data;
                    this.$Progress.finish();
                  });
              },
             deleteRecord(product_id)
             {
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      if (result.value) {
                        this.$Progress.start();
                             this.form.delete('api/product/'+product_id).then(()=>{ 
                              Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                              )
                              this.$Progress.finish();
                              Fire.$emit('AfterCreate');
                            
                        }).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                        });
                      }
                  })
             },
           
         } ,      
        created() {
          if(!this.$gate.isAdmin())
          this.$router.push('notfound');
          else{
           this.loadRecords();
           Fire.$on('AfterCreate',()=>{
             this.loadRecords();
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
