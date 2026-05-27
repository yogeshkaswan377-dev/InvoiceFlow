export default function clientSearch() {
    return {
        query: '',
        results: [],
        selectedClient: null,
        loading: false,
        debounceTimer: null,

        init() {
            this.$watch('query', (value) => {
                clearTimeout(this.debounceTimer);

                this.debounceTimer = setTimeout(() => {
                    if (value.length >= 2) {
                        this.searchClients();
                    } else {
                        this.results = [];
                    }
                }, 300);
            });
        },

        async searchClients() {
            this.loading = true;

            try {
                const response = await fetch(
                    `/clients/search?q=${encodeURIComponent(this.query)}`
                );

                const data = await response.json();

                this.results = data;
            } catch (error) {
                console.error('Client search failed:', error);
            } finally {
                this.loading = false;
            }
        },

        selectClient(client) {
            this.selectedClient = client;
            this.query = client.name;
            this.results = [];

            this.$dispatch('client-selected', client);
        }
    };
}