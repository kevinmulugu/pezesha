<template>
    <section id="customers-component">
        <div class="row">
            <div class="col-sm-8">
                <div id="customers-container" class="p-3">
                    <section id="customers-header" class="mt-3">
                        <h3 class="lead">Pezesha Customers</h3>
                    </section>
                    <section id="add-customer-form" class="my-3">
                        <form>
                            <div class="d-flex justify-content-between align-items-center">
                                <input
                                    v-model="createCustomerForm.name"
                                    v-on:keyup.enter="addCustomer"
                                    minlength="5" maxlength="50"
                                    placeholder="Customer Name"
                                    type="text" class="form-control mr-3">
                                <input
                                    v-model="createCustomerForm.type"
                                    v-on:keyup.enter="addCustomer"
                                    minlength="5" maxlength="50"
                                    placeholder="Customer Type"
                                    type="text" class="form-control mr-3">
                                <button v-if="createCustomerForm.isSubmitting" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>
                                </button>
                                <button v-else @click.prevent="addCustomer" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </section>
                    <section id="customers-list">
                        <ul class="list-group">
                            <div v-if="customers.isLoading" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <li
                                v-if="!customers.isLoading && customers.data.length > 0"
                                v-for="customer in customers.data" :key="customer.id"
                                class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    {{ customer.name }}
                                    <span class="d-flex justify-content-between align-items-center">
                                        <a class="text-success mr-2" href="#" @click.prevent="showEditCustomerForm(customer)">
                                            <i class="fa fa-edit"> </i> Edit
                                        </a>
                                        <a class="text-danger" href="#" @click.prevent="destroy(customer)">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a> &nbsp;
                                        <a class="text-dark" href="#" @click.prevent="showSelectedCustomerLoansModal(customer.loans)">
                                            <i class="fa fa-history"></i> Loans
                                        </a>
                                    </span>
                                </div>
                                <div class="">
                                    <small class="text-muted">{{ customer.type }}</small>
                                </div>
                            </li>
                            <li v-if="!customers.isLoading && customers.data.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No customers found.
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCustomerModalLabel">Update Customer Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section id="edit-customer">
                            <form>
                                <div class="form-group">
                                    <input
                                        v-model="editCustomerForm.name"
                                        v-on:keyup.enter="updateCustomer"
                                        minlength="5" maxlength="50"
                                        placeholder="Name"
                                        type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input
                                        v-model="editCustomerForm.type"
                                        v-on:keyup.enter="updateCustomer"
                                        minlength="5" maxlength="50"
                                        placeholder="Type"
                                        type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button v-if="editCustomerForm.isSubmitting" class="btn btn-success btn-block" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                        <span class="sr-only">Loading...</span>
                                    </button>
                                    <button v-else @click.prevent="updateCustomer" class="btn btn-success btn-block">Update</button>
                                </div>
                            </form>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Loans Modal     -->
        <div class="modal fade" id="loansModal" tabindex="-1" role="dialog" aria-labelledby="loansModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loansModalLabel">Customer Loans</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li
                                v-if="selectedCustomerLoans.length > 0"
                                class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="loan in selectedCustomerLoans" :key="loan.id">
                                            <td>{{ loan.amount }}</td>
                                            <td>{{ loan.status }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                            <li v-if="selectedCustomerLoans.length === 0" class="list-group-item list-group-item-action list-group-item-warning">
                                No Loans found.
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
        name: 'Customers',
        data() {
            return {
                customers: {
                    isLoading: false,
                    data: []
                },
                createCustomerForm: {
                    isSubmitting: false,
                    name: undefined,
                    type: undefined,
                },
                editCustomerForm: {
                    isSubmitting: false,
                    type: undefined,
                    name: undefined,
                },
                selectedCustomerLoans: []
            }
        },
        mounted() {
            this.loadCustomers();
        },
        methods: {
            /**
             * Updates a Customer
             */
            showEditCustomerForm(customer) {
                this.editCustomerForm.name = customer.name;
                this.editCustomerForm.type = customer.type;
                this.editCustomerForm.id = customer.id;
                $('#editCustomerModal').modal('show');
            },

            /**
             * Shows loans modal for the selected modal
             * @param loans
             */
            showSelectedCustomerLoansModal(loans) {
                this.selectedCustomerLoans = loans;
                $('#loansModal').modal('show');
            },

            /**
             * Loads Customers
             */
            loadCustomers() {
                // update loader to loading
                this.customers.isLoading = true;

                axios.get('/customers-json')
                    .then((response) => {
                        this.customers.data = response.data;
                    })
                    .catch((error) => {
                        this.error = 'Unable to load customers. View log for more information';
                    })
                    .finally(() => {
                        // disable loader
                        this.customers.isLoading = false;
                    })
            },

            /**
             * Create a Customer.
             * Uses payload in the this.createCustomerForm param
             */
            addCustomer() {
                // update loader to loading
                this.createCustomerForm.isSubmitting = true;
                axios.post('/customers', this.createCustomerForm)
                    .then((response) => {
                        this.createCustomerForm.name = undefined;
                        this.createCustomerForm.type = undefined;
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Customer Added Successfully',
                        });
                        this.loadCustomers();
                    })
                    .catch((error) => {
                        /**
                         * Check for form validation error. Laravel return http code 422
                         * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                         */
                        if (error.response && error.response.status === 422) {
                            Swal.fire({
                                icon: 'error',
                                title: error.response.data.message,
                                text: _.flatten(_.toArray(error.response.data.errors)),
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: error.response.data.message,
                                text: error.message,
                            });
                        }
                    })
                    .finally(() => {
                        // disable loader
                        this.createCustomerForm.isSubmitting = false;
                    })
            },
            /**
             * Updates a Customer
             *
             */
            updateCustomer() {
                // update loader to loading
                this.editCustomerForm.isSubmitting = true;
                axios.put(`/customers/${this.editCustomerForm.id}`, this.editCustomerForm)
                    .then((response) => {
                        $('#editCustomerModal').modal('hide');
                        this.editCustomerForm.name = undefined;
                        this.editCustomerForm.type = undefined;
                        Swal.fire(
                            'Success!',
                            'Customer Details Updated Successfully',
                            'success'
                        );
                        this.loadCustomers();
                    })
                    .catch((error) => {
                        /**
                         * Check for form validation error. Laravel return http code 422
                         * _ lodash is already loaded by laravel. check resources/js/bootstrap.js
                         */
                        if (error.response && error.response.status === 422) {
                            Swal.fire(
                                error.response.data.message,
                                _.flatten(_.toArray(error.response.data.errors)).toString(),
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'Unable to update customer. View log for more information',
                                'error'
                            );
                        }
                    })
                    .finally(() => {
                        // disable loader
                        this.editCustomerForm.isSubmitting = false;
                    })
            },
            /**
             * Deletes a Customer
             * @param customer
             */
            destroy(customer) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/customers/${customer.id}`)
                            .then((response) => {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                this.loadCustomers();
                            })
                            .catch((error) => {
                                Swal.fire(
                                    'Error!',
                                    'Unable to delete Customer. View log for more information',
                                    'error'
                                );
                            });
                    }
                });
            }
        }
    }
</script>
