<template>
  <div>
    <div id="ajax_loader" class="loader-new" v-if="loader"><div>

      <div id="loader" class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>

    </div></div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
<!--      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href='#profile' role="tab" aria-controls="home" aria-selected="true">Fő Témák old</a>
      </li> -->
      <li class="nav-item" v-for="tabs in tabs_menu">
        <a class="nav-link" id="profile-tab" data-toggle="tab" :href="'#tab-' + tabs.id" role="tab" aria-controls="profile" aria-selected="false">{{tabs.name}}</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
  <!--    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

    <div class="card color">
      <ul class="list-group list-group-flush">
        <li v-for="(list, topics_name) in this.topics_list"class="list-group-item">
          Főtéma: <b class="customLink" @click="topic(topics_name, list.id)">{{topics_name}}</b>  Altémák száma: <b>{{list.count}}</b>  Hozzászólások száma: {{list.id}}<b>?</b>
        </li>
      </ul>
    </div>

  </div> -->
    <div v-for="tabs in tabs_menu" class="tab-pane fade" :id="'tab-' + tabs.id" role="tabpanel" aria-labelledby="profile-tab">

      <div class="card color">
        <ul v-if="tabs.id === 'fo'" class="list-group list-group-flush">
          <li v-for="(list, topics_name) in topics_list" class="list-group-item">
            Főtéma: <b class="customLink" @click="topic(topics_name, list.id)">{{topics_name}}</b>  Altémák száma: <b>{{list.count}}</b>  Hozzászólások száma: (id:{{list.id}})<b>?</b>
          </li>
        </ul>

        <ul v-else class="list-group list-group-flush">
          <li class="list-group-item">
            Az all topics ok {{tabs.name}}
          </li>
        </ul>
      </div>

    </div>
  </div>

  </div>
</template>

<script>
import axios from 'axios';
  Vue.prototype.$axios = axios;

export default{
  name: 'TopicsForm',

  data(){
    return{
      tabs_menu: [{'name': "Fő Témák", 'id': "fo"}],
      loader:  false,
      topics_list: [],
      al_topics_list: [],
      id: null

    }
  },

created(){
  /** Lista adatok lekérése **/
              this.topics_lists();
  /** Ajax loader automatizálása **/
              this.setAxiosLoader();
},

methods: {

  topics_lists(){
    axios.get('/topics_list').then(function(response) {
      console.log('response:' + response.data.success);
      this.topics_list = response.data.topics_list;
    }.bind(this)).catch(function (error) { console.log('error: ' + error); });
  },

  topic(topics_name, id){
  /** Al topics fül létrehozás **/
    this.tabs_menu.push({
      'name': topics_name,
      'id': id
    });
    this.id = id;

    axios.post('/topics_al_list', {
      'id': this.id
    }).then(function(response){
      console.log('response: ' + response.data.success);
      this.al_topics_list = response.data.al_topics_list;
    }.bind(this)).catch(function (error) {console.log('error: ' + error);});

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
  background-color: ;
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
.customLink {
  cursor: pointer;
}
.customLink:hover {
  text-decoration: underline;
}
</style>
