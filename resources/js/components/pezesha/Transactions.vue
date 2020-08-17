<template>
    <section id="transactions-component">
        <div class="row">
            <div class="col-sm-12">
                <div id="transactions-container" class="p-3">
                    <section id="loans-header" class="mt-3">
                        <h3 class="lead">Pezesha Transactions</h3>
                    </section>
                    <section id="transactions-list">
                        <ul class="list-group">
                            <div v-if="transactions.isLoading" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <li
                                v-if="!transactions.isLoading && transactions.data.length > 0"
                                class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Ref</th>
                                            <th>Customer</th>
                                            <th>Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="transaction in transactions.data" :key="transaction.id">
                                            <td>
                                                {{ transaction.amount }}
                                            </td>
                                            <td>{{ transaction.reference }}</td>
                                            <td>{{ transaction.customer.name }}</td>
                                            <td>{{ transaction.time }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li v-if="!transactions.isLoading && transactions.data.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No transactions found.
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import Swal from 'sweetalert2/dist/sweetalert2.js'

    import 'sweetalert2/src/sweetalert2.scss'
    export default {
        name: 'Transactions',
        data() {
            return {
                transactions: {
                    isLoading: false,
                    data: []
                },
            }
        },
        mounted() {
            this.loadTransactions();
        },
        methods: {
            /**
             * Loads transactions
             */
            loadTransactions() {
                // update loader to loading
                this.transactions.isLoading = true;

                axios.get('/transactions-json')
                    .then((response) => {
                        this.transactions.data = response.data;
                    })
                    .catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text:'Unable to load transactions',
                        });
                    })
                    .finally(() => {
                        // disable loader
                        this.transactions.isLoading = false;
                    })
            }

        }
    }
</script>
