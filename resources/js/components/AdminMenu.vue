<template>
<div>
  <div id="ajax_loader" class="loader-new" v-if="loader"><div>

    <div id="loader" class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>

  </div></div>
  <div class="card color">
    <div id="card-header" class="card-header">
      Admin menü
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        Fő téma neve: <input type="text" class="form-control" v-model="main_topics_name">
        <input type="button" @click="main_topics_name_send()" class="btn btn-primary" value="Mentés">
      </li>
      <li class="list-group-item">
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Al téma létrehozás</label>

        <select v-model="list_id" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
          <option selected>Válassz fő témát</option>
          <option v-for="list in this.topics_list" :value="list.id">{{list.topics_name}}</option>  topics_list
        </select>
        Al téma neve: <input type="text" class="form-control" v-model="topics_name">
        <input type="button" @click="topics_name_send()" class="btn btn-primary" value="Mentés">
      </li>
      <li class="list-group-item">
        Felhasználók törlés szerkesztés stb
      </li>
    </ul>
  </div>
</div>
</template>

<script>
import axios from 'axios';
    Vue.prototype.$axios = axios;

export default{
  name: 'adminmenu',

  data(){
    return {
      loader:  false,
      main_topics_name: '',
      topics_name: '',
      list_id: null,
      topics_list: [],

    }
  },

  created(){
                this.main_topics_list();
    /** Ajax loader automatizálása **/
                this.setAxiosLoader();
  },

  methods: {
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

    main_topics_name_send(){
      axios.post('/admin_save_main_topics_name', {
                    'main_topics_name': this.main_topics_name
                  }).then(function(response) {
                    console.log('response:' + response.data.success);
                  }.bind(this)).catch(function (error) { console.log('error: ' + error); });
    },

    topics_name_send(){
      axios.post('/admin_save_topics_name', {
                    'topics_name': this.topics_name,
                    'list_id': this.list_id
                  }).then(function(response) {
                    console.log('response:' + response.data.success);
                  }.bind(this)).catch(function (error) { console.log('error: ' + error); });
    },

    main_topics_list(){
      axios.get('/admin_main_topics_list').then(function(response) {
        console.log('response:' + response.data.success);
        this.topics_list = response.data.topics_list;
      }.bind(this)).catch(function (error) { console.log('error: ' + error); });
    }
  },
}
</script>

<style scoped>
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
