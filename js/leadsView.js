const app = Vue.createApp({

data(){
    return{
        leads: [],
        searchName: '',
        dateFrom: '',
        dateTo: '',
        page: 1,
        role: '',
        message: '',
        messageClass: 'alert'
    }
},

methods:{

async getSession(){
    const response = await fetch('api/auth/authCheck.php');
    const data = await response.json();
    this.role = data.role;
},
async getLeads(){
    console.log("PAGE:", this.page);
    console.log("URL:", `/Leads/api/leads/list.php?page=${this.page}`);
    const url = `api/leads/list.php?page=${this.page}&name=${this.searchName}&date_from=${this.dateFrom}&date_to=${this.dateTo}`;
    const response = await fetch(url);
    const data = await response.json();
    this.leads = data;
},
async completeLead(id){
    const response = await fetch(`api/leads/complete.php?id=${id}`);
    const data = await response.json();
    this.showMessage(data.message);
    this.getLeads();
},
async deleteLead(id){

    if(!confirm("Delete this lead?")) return;
    const response = await fetch(`api/leads/delete.php?id=${id}`);
    const data = await response.json();
    if(response.ok){
        this.showMessage(data.message);
    } else {
        this.showMessage(data.message, true);
    }
    this.getLeads();
},


nextPage(){
    this.page++;
    this.getLeads();
},


prevPage(){
    if(this.page > 1){
        this.page--;
        this.getLeads();
    }
},

},

async mounted(){
    await this.getSession();
    this.getLeads();
}

});

app.mount('#app');