<template>
    <div class="">
        <div class="row" v-if="$gate.isMerchant()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new order</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                     
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#customer">Customer Details</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#products">Products</a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#payments">Payments Details</a>
                      </li>
                       <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#shipping">Shipping Details</a>
                      </li>
                       <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#total">Total</a>
                      </li>
                          
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane container active" id="customer">
                         <div class="row mt-3">
                            <div class="col-12">
                                <label>Currency</label> <span class="red">*</span>  
                                <multiselect v-model="form.currency_id" :options="currencies" :close-on-select="true" :clear-on-select="true" :preserve-search="true" placeholder="Pick one" label="title" track-by="id" :preselect-first="true">
                                  <template slot="currencies" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                </multiselect>

                            </div>
                            <div class="col-12 mt-3">
                                <label>Customer</label> <span class="red">*</span>
                                 <multiselect v-model="form.selected" :options="customers" :close-on-select="true" :clear-on-select="true" :preserve-search="true" placeholder="Pick one" label="name" track-by="id" :preselect-first="true">
                                  <template slot="customers" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                </multiselect> 
                            </div>
                            <div class="col-12 mt-3">
                           
                            <label>Name </label> <span class="red">*</span>
                            <input v-model="form.selected.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="col-6 mt-3">
                            <label>Email </label> <span class="red">*</span>
                            <input v-model="form.selected.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="col-6 mt-3">
                            <label>Mobile </label> <span class="red">*</span>
                            <input v-model="form.selected.telephone" type="text" name="mobile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                            <has-error :form="form" field="mobile"></has-error>
                            </div>
                        </div> 
                       
                      </div>
                      <div class="tab-pane container fade" id="total">
                          <div class="row mt-2 mb-2">
                            <table class="table table-bordered">
                            <thead>
                            <tr> 
                                <th>Product</th>
                                <th>Quantity</th> 
                                <th>Unit price</th> 
                                <th>Total</th> 
                                
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in form.productsrows"  :key="index">
                                
                                <td>   
                                  {{ row.product.name_ar}} 
                                </td>
                                <td> 
                                     {{ row.quantity}} 
                                </td>
                                   <td> 
                                    {{ row.product.price}} 
                                </td>
                                  <td> 
                                    {{ row.total}} 
                                </td>
                                
                            </tr>
                            <tr><td colspan="3" style="text-align:right">Sub-Total:	</td><td>{{ form.productsrows.reduce((acc, item) => acc + item.total, 0)}}</td></tr>
                            <tr><td colspan="3" style="text-align:right">Total:	</td><td>{{ form.productsrows.reduce((acc, item) => acc + item.total, 0)}}</td></tr>
                            </tbody>
                           
                        </table>
                          </div>
                         <div class="row mt-2 mb-2"> 
                             <div class="col-12 mt-3">
                                <label>Payment method </label> <span class="red">*</span> 
                                 <select v-model="form.payment_method"  class="form-control" :class="{ 'is-invalid': form.errors.has('payment_method') }">
                                  <option value="1" selected> Cash on delevery</option>
                                      
                                  </select>
                                </div>
                                 <div class="col-12 mt-3">
                                <label>Order status </label> <span class="red">*</span> 
                                 <select v-model="form.order_status_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('order_status_id') }">
                                  <option value="" selected> please select</option>
                                      <option v-for="n in orderstatuses" :key="n.id" :value="n.id">{{n.name_ar}}</option>
                                  </select>
                                </div>
                                  <div class="col-12 mt-3">
                                <label>Comment </label> 
                                 
                                <textarea id="editor" v-model="form.comment" name="editor1" style="width: 100%"></textarea>
                            
                                </div>
                          </div>  
                          <div class="row mt-5">
                            
                        
                          </div>

                      </div>
                      <div class="tab-pane container fade" id="products">

                        <div class="row mt-3 mt">
                            <table class="table table-bordered">
                            <thead>
                            <tr> 
                                <th>Product</th>
                                <th>Quantity</th> 
                                <th>Unit price</th> 
                                <th>Total</th> 
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in form.productsrows"  :key="index">
                                
                                <td>  
                                      
                                       <multiselect v-model="row.product"   @input="Calculte(row)"  :options="products" :close-on-select="true" :clear-on-select="true" :preserve-search="true" placeholder="Pick one" label="name_ar" track-by="id" :preselect-first="true">
                                        <template slot="customers" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                      </multiselect> 
                                </td>
                                <td>
                                    <input class="form-control" id="quantity"  name="quantity"   @keyup="Calculte(row)"  v-model="row.quantity"/>
                                </td>
                                   <td>
                                    <input class="form-control" id="price"  name="price"   @keyup="Calculte(row)" readonly v-model="row.product.price"/>
                                </td>
                                  <td>
                                    <input class="form-control" v-model="row.total"/>
                                </td>
                               
                                <td> 
                                    <button type="button" @click.prevent="removeRow(index)" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <tr><td></td><td></td><td></td><td></td><td><button class="btn btn-primary btn-xs" @click.prevent="addRow(0)"><i class="fa fa-plus-circle"></i></button></td></tr>
                            </tbody>
                           
                        </table>
                        </div>
                        

                      </div>
                      <div class="tab-pane container fade" id="payments">
                        <div class="panel-body" id="app">
                            <div class="row">
                               <div class="col-12 mt-3">
                                <label>Name </label> <span class="red">*</span>
                                <input v-model="form.payment_name" type="text" name="payment_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('payment_name') }">
                                <has-error :form="form" field="payment_name"></has-error>
                                </div>

                                <div class="col-12 mt-3">
                                <label>Company </label> 
                                <input v-model="form.payment_company" type="text" name="payment_company" class="form-control">
                                </div>

                                 <div class="col-12 mt-3">
                                <label>Address1 </label> <span class="red">*</span>
                                <input v-model="form.payment_address_1" type="text" name="payment_address_1"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('payment_address_1') }">
                                <has-error :form="form" field="payment_address_1"></has-error>
                                </div>

                                <div class="col-12 mt-3">
                                <label>Address2 </label> 
                                <input v-model="form.payment_address_2" type="text" name="payment_address_2"
                                    class="form-control" > 
                                </div> 

                                 <div class="col-12 mt-3">
                                <label>City </label> <span class="red">*</span>
                                <input v-model="form.payment_city" type="text" name="payment_city"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('payment_city') }">
                                <has-error :form="form" field="payment_city"></has-error>
                                </div>

                                 <div class="col-12 mt-3">
                                <label>Postcode </label> 
                                <input v-model="form.payment_postcode" type="text" name="payment_postcode"
                                    class="form-control" >
                                
                                </div>

                                <div class="col-12 mt-3">
                                <label>Country </label> <span class="red">*</span>
                                <input v-model="form.payment_country" type="text" name="payment_country"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('payment_country') }">
                                <has-error :form="form" field="payment_country"></has-error>
                                </div>

                                 <div class="col-12 mt-3">
                                <label>Zone </label> <span class="red">*</span>
                                <input v-model="form.payment_zone" type="text" name="payment_zone"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('payment_zone') }">
                                <has-error :form="form" field="payment_zone"></has-error>
                                </div>
 
                            </div>
                        </div>
                      </div>
                      <div class="tab-pane container fade" id="shipping">
                        <div class="row">
                               <div class="col-12 mt-3">
                                <label>Name </label> <span class="red">*</span>
                                <input v-model="form.shipping_name" type="text" name="shipping_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_name') }">
                                <has-error :form="form" field="shipping_name"></has-error>
                                </div>

                                <div class="col-12 mt-3">
                                <label>Company </label> 
                                <input v-model="form.shipping_company" type="text" name="shipping_company" class="form-control">
                                </div>

                                 <div class="col-12 mt-3">
                                <label>Address1 </label> <span class="red">*</span>
                                <input v-model="form.shipping_address_1" type="text" name="shipping_address_1"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_address_1') }">
                                <has-error :form="form" field="shipping_address_1"></has-error>
                                </div>

                                <div class="col-12 mt-3">
                                <label>Address2 </label> 
                                <input v-model="form.shipping_address_2" type="text" name="shipping_address_2"
                                    class="form-control" > 
                                </div> 

                                 <div class="col-12 mt-3">
                                <label>City </label> <span class="red">*</span>
                                <input v-model="form.shipping_city" type="text" name="shipping_city"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_city') }">
                                <has-error :form="form" field="shipping_city"></has-error>
                                </div>

                                 <div class="col-12 mt-3">
                                <label>Postcode </label> 
                                <input v-model="form.shipping_postcode" type="text" name="shipping_postcode"
                                    class="form-control" >
                                
                                </div>

                                <div class="col-12 mt-3">
                                <label>Country </label> <span class="red">*</span>
                                <input v-model="form.shipping_country" type="text" name="shipping_country"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_country') }">
                                <has-error :form="form" field="shipping_country"></has-error>
                                </div>

                                 <div class="col-12 mt-3">
                                <label>Zone </label> <span class="red">*</span>
                                <input v-model="form.shipping_zone" type="text" name="shipping_zone"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('shipping_zone') }">
                                <has-error :form="form" field="shipping_zone"></has-error>
                                </div>
 
                            </div>
                      </div>
                      
                    </div>
                   
            
            <div class="modal-footer mt-3" > 
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
        title () {  return 'Add Order - '+this.$appName;},
         data () {
          return {
          editMode:false,   
          records:{},     
          categories:{},
          currencies:['list', 'of', 'options'],
          customers:['list', 'of', 'options'], 
          products:{}, 
          orderstatuses:{},
          selected: [], 
          taxs:{},
          // Create a new form instance
          form: new Form({
              id:'',
              selected:[], 
              productsrows: [],
              customer: [],
              currency_id: '', 
              payment_name:'', 
              payment_company:'', 
              payment_address_1: '',
              payment_address_2:'', 
              payment_city:'', 
              payment_postcode:'', 
              payment_country: '',
              payment_country_id:'', 
              payment_zone:'', 
              payment_zone_id:'', 
              payment_address_format: '',
              payment_method:'', 
              payment_code:'', 
              order_status_id:'8', 
              comment: '',
              payment_name:'', 
              shipping_company:'', 
              shipping_address_1: '',
              shipping_address_2:'', 
              shipping_city:'', 
              shipping_postcode:'', 
              shipping_country: '',
              shipping_country_id:'', 
              shipping_zone:'', 
              shipping_zone_id:'', 
              shipping_address_format: '',
              shipping_method:'', 
              shipping_code:'', 
              sort_order:'', 
              subtract:'', 
              status:''
  
          })
          }
          },
         methods:{
           Calculte(row)
           {
             //alert(12);
             console.log(row);
             row.total=row.product.price* row.quantity;
           },
        addRow: function (index) {
            try {
                this.form.productsrows.push({product: "", quantity: 1,unit_price:0,total:0});
            } catch(e)
            {
                console.log(e);
            }
        },
         removeRow: function (index) {
            this.form.productsrows.splice(index, 1);
        },
         addImageRow: function (index) {
            try {
                this.form.images.push({image: "", sort_order: "1"});
            } catch(e)
            {
                console.log(e);
            }
        },
         removeImageRow: function (index) {
            this.form.images.splice(index, 1);
        },
        addDiscountRow: function (index) {
            try {
                this.form.discounts.push({quantity: "1", priority: "1",price:"0",date_start:"",date_end:""});
            } catch(e)
            {
                console.log(e);
            }
        },
         removeDiscountRow: function (index) {
            this.form.discounts.splice(index, 1);
        },
           editRecords()
             {
               if(this.$route.params.id>0)
               {
                 this.editMode=true;
                  this.$Progress.start();  
                  console.log(this.$route.params.id);
                   axios.get(this.$baseUrl+"api/getorder/"+this.$route.params.id).then(
                   ({data})=>
                    {
                      console.log(data.order);
                    this.form.fill(data.order);
                    //this.form.selected=data.products; 
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
                this.form.photo=reader.result;
                
                
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
               updateimages(e,index){

             let file=e.target.files[0];
              let reader = new FileReader();
              if(file['size']<=2111152)
              {
              reader.readAsDataURL(file);
              reader.onload =   (file)=> {
                this.form.images[index].image=reader.result; 
                console.log(this.form.images);
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
console.log(this.form.customer);
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/orders')
                .then(({data})=>{
                  
                  Fire.$emit('AfterCreate');  
                  Toast.fire({
                      type: 'success',
                      title: 'Record created successfully'
                    });
                 this.$Progress.finish();
                 
                })
                .catch(()=>{
                       Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                }); 
             },
             updateRecord()
             {
                this.$Progress.start() 
                this.form.put(this.$baseUrl+'api/orders/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'Order updated successfully'
                    });
                 this.$Progress.finish();
                })
                .catch(()=>{
                  Swal.fire("Failed","There was something wrong","warning");
                    this.$Progress.fail();
                }); 
             },
             getzones(){

             }, 
               getPhoto(){
               let photo=this.form.photo?(this.form.photo.length>100)?this.form.photo:this.$baseUrl+"img/orders/"+this.form.photo:'';
               return photo;
             }, 
             getImage(index){
               let photo=this.form.images[index].image?(this.form.images[index].image.length>100)?this.form.images[index].image:this.$baseUrl+"img/orders/"+this.form.images[index].image:'';
               return photo;
             },
             loadRecords()
             {
                 
                this.$Progress.start(); 
                axios.get(this.$baseUrl+"api/orderlookups").then(
                  ({data})=>
                  {
                      this.currencies=data.currencies; 
                      this.customers=data.customers; 
                      this.products=data.products; 
                      this.orderstatuses=data.orderstatuses; 
                      console.log(this.currencies);
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
          else {
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


