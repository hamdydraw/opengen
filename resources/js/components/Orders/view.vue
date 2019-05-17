<template>
    <div class="content" id="print">
    <div class="page-header">
    <div class="container-fluid">
    <div class="pull-right" style="float: right;">
      <a  v-bind:href="'../print/'+form.id" target="_blank" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Print Invoice"><i class="fa fa-print"></i></a>
      <router-link  :to="{ name: 'ordersaddEdit', params: { id: form.id}}" class="btn btn-default"  data-original-title="Cancel"><i class="fa fa-edit"></i></router-link>
      <router-link to="/orders" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></router-link></div>
     <h1>Orders</h1>
    </div>
    </div>
        <div class="row" v-if="$gate.isMerchant()">
          <div class="col-12">
            
                    <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                       <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
                    </div>
                    <div class="card-body register-card-body">
                   
                    <table class="table">
                    <tbody>
                    
                    <tr>
                    <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Date Added"><i class="fa fa-calendar fa-fw"></i></button></td>
                    <td>{{form.created_at}}</td>
                    </tr>
                    <tr>
                    <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Payment Method"><i class="fa fa-credit-card fa-fw"></i></button></td>
                    <td>Cash On Delivery</td>
                    </tr>
                    <tr>
                    <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Shipping Method"><i class="fa fa-truck fa-fw"></i></button></td>
                    <td>Flat Shipping Rate</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="card">
                       <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user"></i> Customer Details</h3>
                    </div>
                    <div class="card-body register-card-body">
                    <table class="table">
                    <tbody><tr>
                    <td style="width: 1%;"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Customer"><i class="fa fa-user fa-fw"></i></button></td>
                    <td> {{ form.customer.name}}
                    </td>
                    </tr>
                    
                    <tr>
                    <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="E-Mail"><i class="fa fa-envelope-o fa-fw"></i></button></td>
                    <td><a v-bind:href="'mailto:'+form.customer.email"> {{ form.customer.email}}</a></td>
                    </tr>
                    <tr>
                    <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Telephone"><i class="fa fa-phone fa-fw"></i></button></td>
                    <td>{{ form.customer.telephone}}</td>
                    </tr>
                    </tbody></table>
                    </div>
                    </div>
                    </div>
                    
                  </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order(#<span>{{ form.id}}</span>)</h3> 
                <div class="card-tools">  
                 
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                
                <table class="table table-bordered">
                  <thead>
                  <tr>
                  <td style="width: 50%;" class="text-left">Payment Address</td>
                  <td style="width: 50%;" class="text-left">Shipping Address</td>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                  <td class="text-left">{{form.payment_name}}<br>{{form.payment_address_1}}<br>{{form.payment_city}}<br>{{form.payment_address_2}}<br>{{form.payment_postcode}}<br>{{form.payment_zone}}<br>{{form.payment_country}}</td>
                  <td class="text-left">{{form.shipping_name}}<br>{{form.shipping_address_1}}<br>{{form.shipping_city}}<br>{{form.shipping_address_2}}<br>{{form.shipping_postcode}}<br>{{form.shipping_zone}}<br>{{form.shipping_country}}</td>
                  </tr>
                  </tbody>
                </table>
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
                                   {{form.currency_id.symbol_left}}  {{ row.total}} {{form.currency_id.symbol_right}}
                                </td>
                                
                            </tr>
                            <tr><td colspan="3" style="text-align:right">Sub-Total:	</td><td> {{form.currency_id.symbol_left}}{{ form.productsrows.reduce((acc, item) => parseFloat(acc) + parseFloat(item.total), 0)}} {{form.currency_id.symbol_right}}</td></tr>
                            <tr><td colspan="3" style="text-align:right">Total:	</td><td> {{form.currency_id.symbol_left}}{{ form.productsrows.reduce((acc, item) => parseFloat(acc) + parseFloat(item.total), 0)}} {{form.currency_id.symbol_right}}</td></tr>
                            </tbody>
                           
                        </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer"> 
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Order History </h3> 
                <div class="card-tools">  
                 
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                
                  <ul class="nav nav-tabs">
                  <li class="nav-item active"><a href="#tab-history" class="nav-link active" data-toggle="tab" aria-expanded="false">History</a></li>
                  <li class="nav-item"><a href="#tab-additional" class="nav-link" data-toggle="tab" aria-expanded="true">Additional</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab-history">
                    <div id="history"><div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                    <tr>
                    <td class="text-left">Date Added</td>
                    <td class="text-left">Comment</td>
                    <td class="text-left">Status</td>
                    <td class="text-left">Customer Notified</td>
                    </tr>
                    </thead>
                    <tbody> 
                    <tr v-for="(row, index) in form.history"  :key="index"> 
                                <td>   
                                  {{ row.created_at}} 
                                </td>
                                <td> 
                                     {{ row.comment}} 
                                </td>
                                   <td> 
                                    {{ 
                                    row.order_status_name
                                     }} 
                                </td>
                                  <td> 
                                    {{ row.notify==0?"No":"Yes"}} 
                                </td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="row">
                    <div class="col-sm-6 text-left"></div>
                    
                    </div>
                    </div>
                    <br>
                    <fieldset>
                    <legend>Add Order History</legend>
                    
                      <form class="form-horizontal" @submit.prevent="updateRecord()" @keydown="form.onKeydown($event)">
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-order-status">Order Status</label>
                    <div class="col-sm-10">
                     
                     <select v-model="historyform.order_status_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('order_status_id') }">
                        <option value="" selected> Please select</option>
                            <option v-for="n in orderstatuses" :key="n.id" :value="n.id">{{n.name_ar}}</option>
                        </select>
                    </div>
                    </div>
                    
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-notify">Notify Customer</label>
                    <div class="col-sm-10">
                    <input type="checkbox"  v-model="historyform.notify" name="notify" value="1" id="input-notify">
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-comment">Comment</label>
                    <div class="col-sm-10">
                    <textarea name="comment"  v-model="historyform.comment"  rows="8" id="input-comment" class="form-control"></textarea>
                    </div>
                    </div>
                       
                  <div class="modal-footer mt-3" > 
                      <button type="submit" class="btn btn-primary">Add History</button>
                  </div>
                    </form>
                    </fieldset>
                   
                    </div>
                    <div class="tab-pane" id="tab-additional"> <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                    <tr>
                    <td colspan="2">Browser</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>IP Address</td>
                    <td>{{form.ip}}</td>
                    </tr> 
                    <tr>
                    <td>User Agent</td>
                    <td>{{form.user_agent}}</td>
                    </tr>
                    
                    </tbody>
                    </table>
                    </div>
                    </div>
                  </div>
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
        title () {  return 'View Order details - '+this.$appName;},
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
          historyform: new Form({
            id:'',
            order_id:'',
            order_status_id:'',
            order_status_name:'',
            created_at:'',
            notify:'',
            comment:''
          }),
          // Create a new form instance
          form: new Form({
              id:'',
              created_at:'',
              productsrows: [],
              history: [],
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
           print()
           {
              var prtContent = document.getElementById("print");
              var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
              WinPrint.document.write(prtContent.innerHTML);
              WinPrint.document.close();
              WinPrint.focus();
              WinPrint.print();
      WinPrint.close();
           },
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
                     this.form.customer=[]; 
                     this.form.id=data.order.id;
                     this.form.created_at=data.order.created_at;
                     this.form.customer= {"id":data.order.customer_id,"name":data.order.customer_name,"email":data.order.customer_email,"telephone":data.order.customer_telephone}; 
                     this.form.payment_name=data.order.payment_name;
                     this.form.payment_company=data.order.payment_company;
                     this.form.payment_address_1=data.order.payment_address_1;
                     this.form.payment_address_2=data.order.payment_address_2;
                     this.form.payment_city=data.order.payment_city;
                     this.form.payment_postcode=data.order.payment_postcode;
                     this.form.payment_country=data.order.payment_country;
                     this.form.payment_zone=data.order.payment_zone;
                     this.form.payment_method=data.order.payment_method;

                     this.form.shipping_name=data.order.shipping_name;
                     this.form.shipping_company=data.order.shipping_company;
                     this.form.shipping_address_1=data.order.shipping_address_1;
                     this.form.shipping_address_2=data.order.shipping_address_2;
                     this.form.shipping_city=data.order.shipping_city;
                     this.form.shipping_postcode=data.order.shipping_postcode;
                     this.form.shipping_country=data.order.shipping_country;
                     this.form.shipping_zone=data.order.shipping_zone;
                     this.form.shipping_method=data.order.shipping_method;
                     this.form.currency_id={"id":data.order.currency_id,"symbol_left":data.order.symbol_left,"symbol_right":data.order.symbol_right,"code":data.order.currency_code,"value":data.order.currency_value};

                     this.form.comment=data.order.comment;
                     this.form.order_status_id=data.order.order_status_id;
                      var self=this;
                      data.product.forEach(function (value, key) {
                          self.form.productsrows.push({product: {"id":value.id,"name_ar":value.name,"price":value.price}, quantity: value.quantity,unit_price:value.unit_price,total:value.total});
                          
                      });
                      self.form.history=[];
                       data.history.forEach(function (value, key) {
                          self.form.history.push({"id":value.id,"order_id":value.order_id,"order_status_id":value.order_status_id,"order_status_name":value.order_status_name,"created_at":value.created_at,"notify":value.notify,"comment":value.comment});
                          
                          
                      });
                     
 
                     //this.form.fill(data.order);
                     
                     //this.form.comment=data.order.comment;
                     
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
                this.historyform.put(this.$baseUrl+'api/addHistory/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate');
                  this.editRecords(); 
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


