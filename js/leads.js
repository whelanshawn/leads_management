const app = Vue.createApp({

data(){
    return{
        leads: [],
        userId: null, 
        newLead: { name:'', description:'' },
        searchName: '',
        dateFrom: '',
        dateTo: '',
        page: 1,
        role: '',
        message: ''
    }
},

methods:{

async getSession(){
    let response = await fetch('/Leads/api/auth/authCheck.php');
    let data = await response.json();
    this.role = data.role;
    this.userId = data.user_id;
},
async getLeads(){
    console.log("PAGE:", this.page);
    console.log("URL:", `/Leads/api/leads/list.php?page=${this.page}`);
    let response = await fetch(`/Leads/api/leads/list.php?page=${this.page}&name=${this.searchName}&date_from=${this.dateFrom}&date_to=${this.dateTo}`);
    this.leads = await response.json();
},
async createLead(){
    if(!this.newLead.name || !this.newLead.description){
        this.message = "Please fill in all fields";
        return;
    }
    let response = await fetch('/Leads/api/leads/create.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(this.newLead)
    });
    let data = await response.json();
    this.message = data.message;
    this.getLeads();
},

async updateLead(lead){
    if(!lead.name || !lead.description){
        this.message = "Please fill in all fields";
        return;
    }

    try {
        let response = await fetch(`/Leads/api/leads/update.php?id=${lead.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: lead.name,
                description: lead.description
            })
        });

        console.log("Status:", response.status);

        let text = await response.text(); 
        console.log("Raw response:", text);
        let data = JSON.parse(text);

        if(response.ok){
            this.message = data.message;
        } else {
            this.message = data.message || "Update failed";
        }

        this.getLeads();

    } catch (error) {
        console.error("ERROR:", error);
        this.message = "Error updating lead";
    }
},

async completeLead(id){
    await fetch(`/Leads/api/leads/complete.php?id=${id}`);
    this.getLeads();
},

async singleLead(id){
    await fetch(`/Leads/api/leads/complete.php?id=${id}`);
    this.getLeads();
},

async deleteLead(id){
    if(!confirm("Delete lead?")) return;
    let response = await fetch(`/Leads/api/leads/delete.php?id=${id}`);
    let data = await response.json();
    this.message = data.message;
    this.getLeads();
},

prevPage(){
    if(this.page > 1){
        this.page--;
        this.getLeads();
    }
},

nextPage(){
    this.page++;
    this.getLeads();
},
},

async mounted(){
    await this.getSession();
    this.getLeads();
}

}).mount('#app');