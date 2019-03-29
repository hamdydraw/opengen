<template> 
    <div class="">  
        <div class="row" v-if="$gate.isAdminOrVendor()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Length Classes</h3> 
                <div class="card-tools"> 
                   <router-link class="btn btn-success"  to="/lengthclass/addEdit"><i class="fas fa-plus-circle"></i> Add Lengthclass</router-link>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                  
                    <th>Name</th> 
                    <th>Code</th> 
                    <th>Actions</th>
                  </tr> 
                  <tr  v-for="record in records.data" :key="record.length_class_id">
                   
                   <td>{{record.title | upText}}</td> 
                   <td>{{record.code}}</td> 
                    <td> 
                    <router-link  :to="{ name: 'LengthclassaddEdit', params: { id: record.length_class_id}}"><i class="fa fa-edit blue"></i></router-link>
                    / 
                     <a href="#" @click="deleteRecord(record.length_class_id)">
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
         title () {  return 'Length Classes - '+this.$appName;},
         data () {
          return {
          editMode:true,   
          records:{},    
          // Create a new form instance
          form: new Form({
              id:'',
              title: '',
              language_id: '',
              code:'',
              value:''
          })
          }
          },
         methods:{
            
             loadRecords()
             {
                this.$Progress.start(); 
                 axios.get("api/lengthclass").then(
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
                axios.get('api/lengthclass?page=' + page)
                  .then(response => {
                    this.records = response.data;
                    this.$Progress.finish();
                  });
              },
             deleteRecord(length_class_id)
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
                             this.form.delete('api/lengthclass/'+length_class_id).then(()=>{ 
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
          if(!this.$gate.isAdminOrVendor())
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
