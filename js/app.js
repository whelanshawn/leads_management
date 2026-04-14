const app = Vue.createApp({

    data() {
        return {
            login: {
                email: '',
                password: ''
            },
            register: {
                name: '',
                email: '',
                password: ''
            },
            message: ''
        };
    },

    methods: {
        async loginUser() {
            if (!this.login.email || !this.login.password) {
                this.message = "Please enter your Credentials - email and password";
                return;
            }
            try {
                const response = await fetch('/Leads/api/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.login)
                });

                const data = await response.json();
                if (response.ok) {
                    this.message = "Login successful";
                    window.location = "leads.html";
                } else {
                    this.message = data.message;
                }
            } catch (error) {
                console.error(error);
                this.message = "Error connecting to server";
            }
        },

        async registerUser() {
            if (!this.register.name || !this.register.email || !this.register.password) {
                this.message = "Please fill in all fields";
                return;
            }
            try {
                const response = await fetch('/Leads/api/auth/register.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.register)
                });

                const data = await response.json();
                this.message = data.message;
                if (response.ok) {
                    this.register = { name: '', email: '', password: '' };
                }
            } catch (error) {
                console.error(error);
                this.message = "Error connecting to server!";
            }
        }
    }
});

app.mount('#app');