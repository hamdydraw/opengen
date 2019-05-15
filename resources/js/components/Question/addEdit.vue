<template>
    <div class="">
        <div class="row" v-if="$gate.isAdmin()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new question</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                    <div class="row"> 
                        <div class="col-6 mb-3">
                            <label>Question </label> <span class="red">*</span>
                            <input v-model="form.question" type="text" name="question"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('question') }">
                            <has-error :form="form" field="question"></has-error>
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
        title () {  return 'Add question - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          records:{},     
          merchants:{},
          // Create a new form instance
          form: new Form({
              id:'',
              question: ''
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
                 axios.get(this.$baseUrl+"api/getquestion/"+this.$route.params.id).then(
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
                this.form.post(this.$baseUrl+'api/question')
                .then(()=>{
                  Fire.$emit('AfterCreate');  
                  Toast.fire({
                      type: 'success',
                      title: 'Record created successfully'
                    });
                 this.$Progress.finish();
                 this.$router.push('/question');
                })
                .catch(()=>{
                   
                }); 
             },
             updateRecord()
             {
                this.$Progress.start() 
                this.form.put(this.$baseUrl+'api/question/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'Question updated successfully'
                    });
                 this.$Progress.finish();
                 this.$router.push('/question');
                })
                .catch(()=>{
                    this.$Progress.fail();
                }); 
             },
             getzones(){

             }
         } ,      
        created() {
          if(!this.$gate.isAdmin())
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
