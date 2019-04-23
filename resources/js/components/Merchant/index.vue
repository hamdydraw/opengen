<template> 
    <div class="">  
        <div class="row" v-if="$gate.isAdminOrMerchant()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Merchants</h3> 
                <div class="card-tools"> 
                   <router-link class="btn btn-success"  to="/merchant/addEdit"><i class="fas fa-plus-circle"></i> Add merchant</router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                  
                    <th>  Name  </th> 
                    <th> Mobile </th> 
                    <th> Actions </th>
                  </tr> 
                  <tr  v-for="record in records.data" :key="record.id">
                   
                   <td>{{record.name_ar | upText}}</td> 
                   <td>{{record.mobile}}</td> 
                    <td> 
                    <router-link  :to="{ name: 'merchantaddEdit', params: { id: record.id}}"><i class="fa fa-edit blue"></i></router-link>
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
         title () {  return 'Merchants - '+this.$appName;},
         data () {
          return {
          editMode:true,   
          records:{},    
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
            
             loadRecords()
             {
                this.$Progress.start(); 
                 axios.get("api/merchant").then(
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
                axios.get('api/merchant?page=' + page)
                  .then(response => {
                    this.records = response.data;
                    this.$Progress.finish();
                  });
              },
             deleteRecord(merchant_id)
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
                             this.form.delete('api/merchant/'+merchant_id).then(()=>{ 
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
          if(!this.$gate.isAdminOrMerchant())
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
