<template>
    <div class="">
 <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
        <span class="badge badge-danger navbar-badge">{{ alerts.length }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a  v-bind:href="'/product/addEdit/'+record.id" class="dropdown-item"  v-for="record in alerts" :key="record.id">
              
            <!-- Message Start -->
            <div class="media">
              
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{ record.name_ar}} 
                </h3>
                <p class="text-sm">Minimum :{{ record.minimum}}</p>
                <p class="text-sm text-muted">Quantity :{{ record.quantity}}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
        
          <div class="dropdown-divider" style="display:none"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
  </div>
    
</template>
<script>
    export default {
          data () {
          return {
            alerts:{}
          }
          },
          methods:{
        ProductAlert(){
            this.$Progress.start();
            axios.get(this.$baseUrl+"api/getproductalert").then(
                ({data})=>
                {
                this.alerts=data;
                console.log(data);
                this.$Progress.finish();
                }
                );
    }
          },
             created() {
                 this.ProductAlert();
             }
       }
    
</script>
