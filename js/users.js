const app = Vue.createApp({

data(){
    return{
        users: [],
        newUser: { name:'', email:'', role:'role3' },
        userSearch: '',
        page: 1,
        role: '',
        message: ''
    }
},

methods:{

async getSession(){
    const res = await fetch('api/auth/authCheck.php');
    const data = await res.json();
    this.role = data.role;
},

async getUsers(){
    const res = await fetch(`api/users/list.php?page=${this.page}&search=${this.userSearch}`);
    this.users = await res.json();
},

async createUser(){
    if(!this.newUser.name || !this.newUser.email){
        this.message = "Fill all fields";
        return;
    }

    const res = await fetch('api/users/create.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(this.newUser)
    });

    const data = await res.json();
    this.message = data.message;
    this.getUsers();
},

async deleteUser(id){
    if(!confirm("Delete user?")) return;

    const res = await fetch(`api/users/delete.php?id=${id}`);
    const data = await res.json();
    this.message = data.message;
    this.getUsers();
},

async updateUser(user){
    await fetch(`api/users/update.php?id=${user.id}`,{
        method:'PUT',
        body: JSON.stringify({ role: user.role })
    });
},

prevPage(){
    if(this.page > 1){
        this.page--;
        this.getUsers();
    }
},

nextPage(){
    this.page++;
    this.getUsers();
}

},

async mounted(){
    await this.getSession();
    this.getUsers();
}

});

app.mount('#app');