<template>
  <div>
    <div id="ajax_loader" class="loader-new" v-if="loader"><div>

      <div id="loader" class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>

    </div></div>

    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Fő Témák</a>
      </li>
      <li class="nav-item" v-if="topics === true">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{topics_name}}</a>
      </li>
      <li class="nav-item" v-show>
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">szöveg</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


    <div class="card color">
      <ul class="list-group list-group-flush">
        <li v-for="(list, topics_name) in this.topics_list"class="list-group-item">
          Főtéma: <b><a @click="topic(topics_name)" href="#" >{{topics_name}}</a></b>  Altémák száma: <b>{{list}}</b>  Hozzászólások száma: <b>?</b>
        </li>
      </ul>
    </div>

  </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Al topics adatai</div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">szöveg</div>
  </div>

  </div>
</template>

<script>
import axios from 'axios';

export default{
  name: 'TopicsForm',

  data(){
    return{
      topics_name: "",
      topics: false,
      loader:  false,
      topics_list: [],

    }
  },

created(){
              this.topics_lists();
  /** Ajax loader automatizálása **/
              this.setAxiosLoader();
},

methods: {

  topic(topics_name){
    this.topics_name = topics_name;
    this.topics = true;
  },

  setAxiosLoader() {
                  axios.interceptors.request.use((config) => {
                      this.loader = true;
                  return config;
              }, (error) => {
                      this.loader = false;
                      return Promise.reject(error);
                  });
                  axios.interceptors.response.use((response) => {
                      this.loader = false;
                  return response;
              }, (error) => {
                      this.loader = false;
                      return Promise.reject(error);
                  });
              },

              topics_lists(){
                axios.get('/topics_list').then(function(response) {
                  console.log('response:' + response.data.success);
                  this.topics_list = response.data.topics_list;
                }.bind(this)).catch(function (error) { console.log('error: ' + error); });
              }
  },
}

</script>

<style scoped>

.card>.list-group:first-child .list-group-item:first-child {
     border-top-left-radius: .0rem;
     border-top-right-radius: .0rem;
}

.list-group-item:first-child {
    /* border-top-left-radius: inherit; */
    /*border-top-right-radius: inherit; */
}

.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
  color: black;
      background-color: #b4cee7;
      border-color: #dee2e6 #dee2e6 #f8fafc;
}
a{
  color: black;
}

a:hover{
  color: black;
}
#loader{
  color: green;
  position: relative;
  top: 50%;
  left: 50%;

  width: 5rem;
  height: 5rem;
}

#ajax_loader{
  position: fixed;
  width: 100%;
  height: 100%;
  padding-top: 250px;
  background-color: black;
  opacity: 0.5;
  z-index: 99;
  top: 0px;
  left: 0px;
}

#card-header{
  color: white;
}

.color{
  background-color: #5b5b5b;
}
.color li{
  background-color: #b5c1c2;
}
</style>
