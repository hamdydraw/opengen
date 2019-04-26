<template>
    <div class="">
        <div class="row" v-if="$gate.isAdmin()">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Add new product</h3> 
                <div class="card-tools">  

                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body register-card-body">
                <form @submit.prevent="editMode?updateRecord():createRecord()" @keydown="form.onKeydown($event)">
                     
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general">General</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#links">Links</a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#attributes">Attributes</a>
                      </li>
                       <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#options">Options</a>
                      </li>
                       <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#image">Image</a>
                      </li>
                         <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#discounts">Discounts</a>
                      </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane container active" id="general">
                         <div class="row mt-3">
                            <div class="col-6">
                                <label>Product name arabic</label> <span class="red">*</span>
                                <input v-model="form.name_ar" type="text" name="name_ar"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name_ar') }">
                                <has-error :form="form" field="name_ar"></has-error>
                            </div>
                            <div class="col-6">
                                <label>Product name english</label> 
                                <input v-model="form.name_en" type="text" name="name_en"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name_en') }">
                                <has-error :form="form" field="name_en"></has-error>
                            </div>
                        </div>
                         <div class="row mt-2"> 
                        <div class="col-12">
                            <label>Description</label> 
                            <textarea id="editor" v-model="form.description" name="editor1" style="width: 100%"></textarea>
                           </div> 
                        </div> 
                         <div class="row mt-3">
                            <div class="col-6">
                                <label>Product price</label> <span class="red">*</span>
                                <input v-model="form.price" type="text" name="price"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                                <has-error :form="form" field="price"></has-error>
                            </div>
                            <div class="col-6">
                                <label>Model</label> 
                                <input v-model="form.model" type="text" name="model"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('model') }">
                                <has-error :form="form" field="model"></has-error>
                            </div>
                        </div>
                         <div class="row mt-3">
                            <div class="col-6">
                                <label>Product code</label> <span class="red">*</span>
                                <input v-model="form.code" type="text" name="code"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                                <has-error :form="form" field="code"></has-error>
                            </div>
                             <div class="col-6">
                            <label>Tax class</label> 
                        
                          <select v-model="form.tax_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('tax_id') }">
                            <option value="" selected> Please select</option>
                                <option v-for="n in taxs" :key="n.id" :value="n.id">{{n.name}}</option> 
                            </select>
                            
                            <has-error :form="form" field="tax_id"></has-error>
                            </div>

                        </div>
                          <div class="row mt-3">
                            <div class="col-6">
                                <label>Quantity</label> 
                                <input v-model="form.quantity" type="text" name="quantity"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                                
                            </div>
                             <div class="col-6">
                            <label>Minimum Quantity</label> 
                            <input v-model="form.minimum" type="text" name="minimum"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('minimum') }">
                                <has-error :form="form" field="minimum"></has-error>
                            </div>

                        </div>
                            <div class="row mt-3">
                            
                                <label class="col-2">Dimensions (L x W x H)</label> 
                                <input v-model="form.length" placeholder="Length" type="text" name="length" class="col-3 ml-2 form-control" >
                                <input v-model="form.width" placeholder="Width" type="text" name="width" class="col-3 ml-2 form-control" >
                                <input v-model="form.heigth" placeholder="Heigth"  type="text" name="heigth" class="col-3 ml-2 form-control" >
                              
                         </div>
                          <div class="row mt-3">
                            <div class="col-6">
                                <label>Weight	</label> 
                                <input v-model="form.weight	" type="text" name="weight"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('weight') }">
                                <has-error :form="form" field="weight	"></has-error>
                            </div>
                             <div class="col-6">
                            <label>Weight class</label> 
                            <select v-model="form.weight_class_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('weight_class_id') }">
                            <option value="" selected> Please select</option>
                                <option v-for="n in weightclass" :key="n.weight_class_id" :value="n.weight_class_id">{{n.title}}</option> 
                            </select>
                            <has-error :form="form" field="weight_class_id"></has-error>
                            </div> 
                        </div>
                          <div class="row mt-3 mt">
                            <div class="col-6">
                                <label>Sort order	</label> 
                                <input v-model="form.sort_order	" type="text" name="sort_order"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('sort_order') }">
                                <has-error :form="form" field="sort_order	"></has-error>
                            </div>
                             <div class="col-6">
                            <label>Length class</label> 
                            <select v-model="form.length_class_id"  class="form-control" :class="{ 'is-invalid': form.errors.has('length_class_id') }">
                            <option value="" selected> Please select</option>
                                <option v-for="n in lengthclass" :key="n.length_class_id" :value="n.length_class_id">{{n.title}}</option> 
                            </select>
                            <has-error :form="form" field="length_class_id"></has-error>
                            </div> 
                        </div>

                      </div>
                      <div class="tab-pane container fade" id="image">
                         <div class="row mt-2 mb-2"> 
                            <div class="col-4">
                            <label>Photo</label> 
                             <input type="file"   @change="updatePhoto"  class="form-control" id="photo" placeholder="photo">
                            <has-error :form="form" field="photo"></has-error>
                            </div>
                            <div class="col-2"> 
                            <img class="img-circle" width="100" :src="getPhoto()" alt="Image"> 
                            </div>
                          </div>  
                          <div class="row mt-5">
                            <table class="table table-hover">
                            <thead>
                            <tr>
                                
                                <th>Additional Images	</th>
                                <th>Sort order</th> 
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in form.images"  :key="index">
                                
                                <td>  
                                      <input type="file"   @change="updateimages($event,index)"  class="form-control" id="photo" placeholder="photo">
                                      <img class="img-circle" width="100" :src="getImage(index)" alt="Image"> 
                                </td>
                                <td>
                                    <input class="form-control" v-model="row.sort_order"/>
                                </td> 
                                <td> 
                                  <button type="button" @click.prevent="removeImageRow(index)" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <tr><td></td><td></td><td><button class="btn btn-primary btn-xs" @click.prevent="addImageRow(0)"><i class="fa fa-plus-circle"></i></button></td></tr>
                            </tbody>
                           
                        </table>
                        
                          </div>

                      </div>
                      <div class="tab-pane container fade" id="links">

                        <div class="row mt-3 mt">
                            <div class="col-6">
                                <label>Categories	</label> 
                             
                                 <multiselect v-model="form.categories" :options="categories" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name_ar" track-by="id" :preselect-first="true">
                                  <template slot="categories" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                </multiselect>
                            </div>
                              
                        </div>
                        

                      </div>
                      <div class="tab-pane container fade" id="attributes">
                        <div class="panel-body" id="app">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                
                                <th>Attribute</th>
                                <th>Text</th> 
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in form.attributerows"  :key="index">
                                
                                <td> 
                                      
                                      <select v-model="row.attribute_id"  class="form-control" >
                                      <option value="" selected> Please select</option>
                                          <option v-for="n in attributes" :key="n.id" :value="n.id">{{n.name_ar}}</option> 
                                      </select>
                                </td>
                                <td>
                                    <input class="form-control" v-model="row.text"/>
                                </td>
                                 
                               
                                <td>
                                    
                                    
                                    <button type="button" @click.prevent="removeRow(index)" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <tr><td></td><td></td><td><button class="btn btn-primary btn-xs" @click.prevent="addRow(0)"><i class="fa fa-plus-circle"></i></button></td></tr>
                            </tbody>
                           
                        </table>
                        
                    </div>
                      </div>
                      <div class="tab-pane container fade" id="options">options</div>
                      <div class="tab-pane container fade" id="discounts">discounts</div>
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
        title () {  return 'Add Product - '+this.$appName;},
         data () {
          return {
          editMode:false,  
          
          
          records:{},     
          categories:{},
          lengthclass:{},
          weightclass:{}, 
          attributes:{}, 
          selected: null, 
          taxs:{},
          // Create a new form instance
          form: new Form({
              id:'',
              selected:'',
              categories:'',
              attributerows: [],
              images: [],
              name_ar: '',
              name_en:'', 
              photo:'',
              model:'', 
              description:'', 
              code: '',
              price:'', 
              tax_id:'', 
              quantity:'1', 
              minimum: '1',
              stock_status_id:'', 
              r_shipping:'', 
              length:'', 
              width: '',
              heigth:'', 
              weight:'', 
              weight_class_id:'', 
              length_class_id: '',
              sort_order:'', 
              subtract:'', 
              status:'', 
              tag:'',
              meta_title:'',
              meta_description:'',
              meta_keyword:'',
          })
          }
          },
         methods:{
               addRow: function (index) {
            try {
                this.form.attributerows.push({attribute_id: "", text: ""});
            } catch(e)
            {
                console.log(e);
            }
        },
         removeRow: function (index) {
            this.form.attributerows.splice(index, 1);
        },
         addImageRow: function (index) {
            try {
                this.form.images.push({image: "", sordt_order: ""});
            } catch(e)
            {
                console.log(e);
            }
        },
         removeImageRow: function (index) {
            this.form.images.splice(index, 1);
        },
           editRecords()
             {
               if(this.$route.params.id>0)
               {
                 this.editMode=true;
                  this.$Progress.start();  
                  console.log(this.$route.params.id);
                 axios.get(this.$baseUrl+"api/getproduct/"+this.$route.params.id).then(
                   ({data})=>
                    {
                    this.form.fill(data.product);
                    this.form.categories=data.categories;
                    this.form.attributerows=data.attributes;
                    this.form.images=data.images;
                    console.log(this.form.images);
                    this.getzones(this.form.country_id);
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
console.log(this.form.selected);
                this.$Progress.start() 
                this.form.post(this.$baseUrl+'api/product')
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
                this.form.put(this.$baseUrl+'api/product/'+this.$route.params.id)
                .then(()=>{
                  Fire.$emit('AfterCreate'); 
                  Toast.fire({
                      type: 'success',
                      title: 'Product updated successfully'
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
               let photo=this.form.photo?(this.form.photo.length>100)?this.form.photo:this.$baseUrl+"img/product/"+this.form.photo:'';
               return photo;
             }, 
             getImage(index){
               let photo=this.form.images[index].image?(this.form.images[index].image.length>100)?this.form.images[index].image:this.$baseUrl+"img/product/"+this.form.images[index].image:'';
               return photo;
             },
             loadRecords()
             {
                 
                this.$Progress.start(); 
                 axios.get(this.$baseUrl+"api/productlookups").then(
                   ({data})=>
                    {
                        this.categories=data.categories; 
                        this.taxs=data.taxrates; 
                        this.weightclass=data.weightclass; 
                        this.lengthclass=data.lengthclass; 
                        this.attributes=data.attributes; 
                        this.$Progress.finish();
                    }
                    ).catch(()=>{
                        Swal.fire("Failed","There was something wrong","warning");
                            this.$Progress.finish();
                        });
                   

             }
         } ,      
        created() {
          if(!this.$gate.isAdmin())
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


