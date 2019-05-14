<template> 
    <div class="">  
        <div class="row" v-if="$gate.isMerchant()">

          <div class="col-9">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orders</h3> 
                <div class="card-tools"> 
                   <router-link class="btn btn-success"  to="/orders/addEdit"><i class="fas fa-plus-circle"></i> Add order</router-link>
                </div>
              </div> 
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                  
                    <th v-text="$ml.get('orderid')">   </th> 
                    <th v-text="$ml.get('customer')">  </th> 
                    <th v-text="$ml.get('status')">  </th> 
                    <th v-text="$ml.get('total')">  </th> 
                    <th v-text="$ml.get('dateadded')">  </th> 
                    <th v-text="$ml.get('actions')">  </th>
                  </tr> 
                  <tr  v-for="record in records.data" :key="record.id">
                   
                   <td>{{record.id }}</td> 
                   <td>{{record.customer_name|upText}} </td> 
                   <td>{{record.order_status.name_ar}}</td> 
                   <td>{{record.total}}</td> 
                   <td>{{record.created_at}}</td> 
                    <td> 
                      <router-link  :to="{ name: 'ordersview', params: { id: record.id}}"><i class="fa fa-eye blue"></i></router-link>
                      /
                    <router-link  :to="{ name: 'ordersaddEdit', params: { id: record.id}}"><i class="fa fa-edit blue"></i></router-link>
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
          <div id="filter-product" class="col-md-3 col-md-push-9 col-sm-12 hidden-sm hidden-xs ">
                <div class="card">
                <div class="card-header">
                <h3 class="card-title"><i class="fa fa-filter"></i> Search</h3>
                </div>
                <div class="card-body register-card-bod">
                  <form @submit.prevent="search()" @keydown="searchform.onKeydown($event)">
                <div class="form-group">
                <label class="control-label" for="input-name">Order ID</label>
                <input type="text" name="filter_id"  v-model="searchform.id"   value="" placeholder="Order ID" id="input-name" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                </div>
               
                <div class="form-group">
                <label class="control-label" for="input-price">Customer</label>
                <input type="text" name="filter_price" value=""  v-model="searchform.customer"   placeholder="Customer" id="input-price" class="form-control">
                </div>
                <div class="form-group">
                <label class="control-label" for="input-quantity">Status</label>
                
                <select v-model="searchform.status"  class="form-control" >
                            <option value="" selected> Please select</option>
                                <option v-for="n in orderstatuses" :key="n.id" :value="n.id">{{n.name_ar}}</option> 
                </select>
                </div>
                
                <div class="form-group text-right">
                <button type="submit" id="button-filter" class="btn btn-default"><i class="fa fa-filter"></i> Search</button>
                </div>
                  </form>
                </div>
                </div>
            </div>
        </div>
       
        
    </div>
    
</template>

<script>
    export default {
         title () {  return 'Orders - '+this.$appName;},
         data () {
          return {
          editMode:true,   
          records:{},    
          orderstatuses:{},
          // Create a new form instance
          form: new Form({
              id:'',
              customer: '',
              status:'',
              OrderStatus:'',
              total:'', 
              created_at:''
          }),
           searchform: new Form({
              id: '',
              customer:'', 
              status:'', 
              total:'', 
          })
          }
          },
         methods:{
              getPhoto(product_photo){
               let photo=product_photo?(this.form.photo.length>100)?product_photo:this.$baseUrl+"img/orders/"+product_photo:this.$baseUrl+"img/no_image.jpg";
               return photo;
             },
             search(){
                    this.$Progress.start() 
                    let name=this.searchform.name;
                   this.searchform.post(this.$baseUrl+'api/searchorders').then(
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
             loadRecords()
             {
                this.$Progress.start(); 
                 axios.get("api/orders").then(
                   ({data})=>
                    {
                    this.records=data;
                    this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                    }); 
                  this.$Progress.start(); 
                    ///loockups
                     axios.get(this.$baseUrl+"api/orderlookups").then(
                   ({data})=>
                    {
                        this.orderstatuses=data.orderstatuses; 
                        this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
             },
             getResults(page = 1) {
               this.$Progress.start(); 
                axios.get('api/orders?page=' + page)
                  .then(response => {
                    this.records = response.data;
                    this.$Progress.finish();
                  });
              },
             deleteRecord(orders_id)
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
                             this.form.delete('api/orders/'+orders_id).then(()=>{ 
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
          if(!this.$gate.isMerchant())
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
