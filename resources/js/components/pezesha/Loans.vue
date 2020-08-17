<template>
    <section id="loans-component">
        <div class="row">
            <div class="col-sm-12">
                <div id="loans-container" class="p-3">
                    <section id="loans-header" class="mt-3">
                        <h3 class="lead">Pezesha Loans</h3>
                    </section>
                    <section id="loans-list">
                        <ul class="list-group">
                            <div v-if="loans.isLoading" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <li
                                v-if="!loans.isLoading && loans.data.length > 0"
                                class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="loan in loans.data" :key="loan.id">
                                            <td>
                                                <span class="d-block">{{ loan.customer.name }}</span>
                                                <span class="badge badge-pill badge-info">{{ loan.customer.type}}</span>
                                            </td>
                                            <td>{{ loan.amount }}</td>
                                            <td>{{ loan.status }}</td>
                                            <td>
                                                <div class="links">
                                                    <a @click.prevent="showSelectedCustomerFundingsModal(loan.loan_fundings)" href="#">
                                                        <span class="text-success">Fundings <i class="fa fa-envelope"></i></span>
                                                    </a>
                                                    &nbsp;&boxv;&nbsp;
                                                    <a @click="showSelectedCustomerPaymentsModal(loan.payments)" href="#">
                                                        <span class="text-primary">Payments <i class="fa fa-history"></i></span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li v-if="!loans.isLoading && loans.data.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No loans found.
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
        <!--   Loan Funding Modal     -->
        <div class="modal fade" id="loanFundingsModal" tabindex="-1" role="dialog" aria-labelledby="loanFundingsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loanFundingsModalLabel">Loan Fundings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li
                                v-if="selectedCustomerFundings.length > 0"
                                class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="fund in selectedCustomerFundings" :key="fund.id">
                                            <td>{{ fund.amount }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li v-if="selectedCustomerFundings.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No Loan fundings found.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
         <!--   Loan Payment Modal     -->
        <div class="modal fade" id="loanPaymentModal" tabindex="-1" role="dialog" aria-labelledby="loanPaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loanPaymentModalLabel">Loan Payments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li
                                v-if="selectedCustomerPayments.length > 0"
                                class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Ref</th>
                                            <th>time</th>
                                            <th>Paymentscol</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="payment in selectedCustomerPayments" :key="payment.id">
                                            <td>{{ payment.transaction.amount }}</td>
                                            <td>{{ payment.transaction.reference }}</td>
                                            <td>{{ payment.transaction.time }}</td>
                                            <td>{{ payment.paymentscol }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li v-if="selectedCustomerPayments.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No Loan payments found.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
    import Swal from 'sweetalert2/dist/sweetalert2.js'

    import 'sweetalert2/src/sweetalert2.scss'
    export default {
        name: 'Loans',
        data() {
            return {
                loans: {
                    isLoading: false,
                    data: []
                },
                selectedCustomerFundings: [],
                selectedCustomerPayments: [],
            }
        },
        mounted() {
            this.loadLoans();
        },
        methods: {
            /**
             * Loads Loans
             */
            loadLoans() {
                // update loader to loading
                this.loans.isLoading = true;

                axios.get('/loans-json')
                    .then((response) => {
                        this.loans.data = response.data;
                    })
                    .catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text:'Unable to load loans',
                        });
                    })
                    .finally(() => {
                        // disable loader
                        this.loans.isLoading = false;
                    })
            },
            /**
             * Show Loan Fundings for the selected loan
             * @param fundings
             */
            showSelectedCustomerFundingsModal(fundings) {
                this.selectedCustomerFundings = fundings;
                $('#loanFundingsModal').modal('show');
            },
            /**
             * Shows Payments made to the selected Loan
             * @param payments
             */
            showSelectedCustomerPaymentsModal(payments) {
                this.selectedCustomerPayments = payments;
                $('#loanPaymentModal').modal('show');
            },
        }
    }
</script>
