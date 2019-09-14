<template>
  <div class="container-fluid">
    <div class="container">
      <div class="row mt-3">
        <div class="col-sm-6">
          <h3 class="text-info">Customers</h3>
        </div>
        <div class="col-sm-6">
          <button @click="showAddModal = true;" class="btn btn-info float-right">
            <i class="fas fa-user"></i>&nbsp; New Customer
          </button>
        </div>
      </div>
      <hr class="bg-info" />
      <div v-if="succMsg" class="alert alert-success">New Customer Added Successfully!</div>
      <div v-if="updateMsg" class="alert alert-success">Customer Updated!</div>
      <div v-if="delMsg" class="alert alert-danger">Customer Deleted</div>
      <!-- Displaying Customers -->
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="text-center bg-info text-light">
                <th>ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center" v-for="customer in customers" v-bind:key="customer.id">
                <td>{{customer.id}}</td>
                <td>{{customer.email}}</td>
                <td>{{customer.firstname}}</td>
                <td>{{customer.lastname}}</td>
                <td>{{customer.phone}}</td>
                <td>
                  <button @click="editCustomer(customer)" class="btn btn-success">
                    <i class="fas fa-edit"></i>
                  </button>
                </td>
                <td>
                  <button @click="deleteCustomer(customer.id)" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                <a
                  class="page-link"
                  href="#"
                  @click="fetchCustomers(`http://laravel.test/api/customers?page=1<!--  -->`)"
                >First Page</a>
              </li>
              <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                <a
                  class="page-link"
                  href="#"
                  @click="fetchCustomers(pagination.prev_page_url)"
                >Previous</a>
              </li>
              <li class="page-item disabled">
                <a
                  href
                  class="page-link text-dark"
                >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
              </li>
              <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                <a class="page-link" href="#" @click="fetchCustomers(pagination.next_page_url)">Next</a>
              </li>
              <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                <a
                  class="page-link"
                  href="#"
                  @click="fetchCustomers(`http://laravel.test/api/customers?page=${pagination.last_page}`)"
                >Last Page : {{pagination.last_page}}</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- Add New Customer Model -->
    <div id="overlay" v-if="showAddModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Customer</h5>
            <button @click="showAddModal=false;" class="close" type="button">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <div v-if="validMsg" class="alert alert-danger">Please Fill All Aviable Fields</div>
            <form action @submit.prevent="addCustomer">
              <div class="form-group">
                <input
                  type="email"
                  placeholder="Enter Email..."
                  v-model="customer.email"
                  class="form-control form-control-lg"
                />
                <input
                  type="text"
                  v-model="customer.firstname"
                  placeholder="Enter Customer's First Name..."
                  class="form-control form-control-lg"
                />
                <input
                  type="text"
                  v-model="customer.lastname"
                  placeholder="Enter Customer's Last Name..."
                  class="form-control form-control-lg"
                />
                <input
                  type="text"
                  v-model="customer.phone"
                  placeholder="Enter Customer's Phone Nunber..."
                  class="form-control form-control-lg"
                />
              </div>
              <div class="form-group">
                <button
                  v-bind:class="[{disabled: canEdit == false}]"
                  type="submit"
                  class="btn btn-info btn-block btn-lg"
                >Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      customers: [],
      customer: {
        id: "",
        email: "",
        firstname: "",
        lastname: "",
        phone: "",
        regtime: ""
      },
      customer_id: "",
      pagination: {},
      edit: false,
      canEdit: false,
      succMsg: false,
      delMsg: false,
      updateMsg: false,
      validMsg: false,
      showAddModal: false
    };
  },

  created() {
    this.fetchCustomers();
  },

  methods: {
    fetchCustomers(page_url) {
      let vm = this;
      page_url = page_url || "/api/customers";
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.customers = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        first_page: meta.from,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    deleteCustomer(id) {
      if (confirm("Are You Sure?")) {
        fetch(`api/customer/${id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            this.delMsg = true;
            setTimeout(() => {
              this.delMsg = false;
            }, 2000);
            this.fetchCustomers(
              `http://laravel.test/api/customers?page=${this.pagination.current_page}`
            );
          })
          .catch(err => console.log(err));
      }
    },
    addCustomer() {
      if (this.checkValidaty()) {
        //Add
        this.customer.regtime = this.customer.regtime
          ? this.customer.regtime
          : Math.floor(new Date().valueOf() / 1000);
        if (this.edit === false) {
          fetch("api/customer", {
            method: "post",
            body: JSON.stringify(this.customer),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              this.customer.email = "";
              this.customer.firstname = "";
              this.customer.lastname = "";
              this.customer.phone = "";
              this.customer.regtime = "";
              this.succMsg = true;
              setTimeout(() => {
                this.succMsg = false;
              }, 2000);
              this.showAddModal = false;
              this.fetchCustomers(
                `http://laravel.test/api/customers?page=${this.pagination.current_page}`
              );
            })
            .catch(err => console.log(err));
        } else {
          //Update
          fetch("api/customer", {
            method: "put",
            body: JSON.stringify(this.customer),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              this.customer.email = "";
              this.customer.firstname = "";
              this.customer.lastname = "";
              this.customer.phone = "";
              this.customer.regtime = "";
              this.updateMsg = true;
              setTimeout(() => {
                this.updateMsg = false;
              }, 2000);
              this.showAddModal = false;
              this.fetchCustomers(
                `http://laravel.test/api/customers?page=${this.pagination.current_page}`
              );
            })
            .catch(err => console.log(err));
        }
      } else {
        this.validMsg = true;
        setTimeout(() => {
          this.validMsg = false;
        }, 2500);
      }
    },
    editCustomer(customer) {
      this.edit = true;
      this.customer.id = customer.id;
      this.customer.customer_id = customer.id;
      this.customer.email = customer.email;
      this.customer.firstname = customer.firstname;
      this.customer.lastname = customer.lastname;
      this.customer.phone = customer.phone;
      this.customer.regtime = customer.regtime;
      this.showAddModal = true;
    },
    checkValidaty() {
      if (
        this.customer.email != "" &&
        this.customer.firstname != "" &&
        this.customer.lastname != "" &&
        this.customer.phone != ""
      ) {
        this.canEdit = true;
        return true;
      } else {
        this.canEdit = false;
        return false;
      }
    }
  }
};
</script>