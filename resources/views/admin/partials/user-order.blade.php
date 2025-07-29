 <div class="container py-4">
     <div class="card shadow-sm">
         <div class="card-header bg-white d-flex justify-content-between align-items-center">
             <h2 class="h4 mb-0 text-primary">
                 <i class="fas fa-user-clock me-2"></i>User Payment Orders
             </h2>

         </div>

         <div class="card-body">

             <div class="table-responsive">
                 <table class="table table-striped table-hover" id="payments-table">
                     <thead class="table-light">
                         <tr>
                             <th>#</th>
                             <th><i class="fas fa-user me-2"></i>User Id</th>
                             <th><i class="fas fa-box me-2"></i>Package Id</th>
                             <th><i class="fas fa-user me-2"></i>Booking Id</th>
                             <th><i class="fas fa-dollar-sign me-2"></i>Amount</th>
                             <th><i class="fas fa-credit-card me-2"></i>Payment Status</th>
                             <th><i class="fas fa-tasks me-2"></i>Action</th>
                         </tr>
                     </thead>
                 </table>
             </div>
         </div>
     </div>


     <div class="card shadow-sm">
         <div class="card-header bg-white d-flex justify-content-between align-items-center">
             <h2 class="h4 mb-0 text-primary">
                 <i class="fas fa-user-clock me-2"></i>User Booking Records
             </h2>
         </div>

         <div class="card-body">

             <div class="table-responsive">
                 <table id="bookings-table" class="table table-striped table-hover">
                     <thead class="table-light">
                         <tr>
                             <th>#</th>
                             <th scope="col"><i class="fas fa-user me-2"></i>User Name</th>
                             <th scope="col"><i class="fas fa-box me-2"></i>Package ID</th>
                             <th scope="col"><i class="fas fa-user me-2"></i>Name</th>
                             <th scope="col"><i class="fas fa-envelope me-2"></i>Email</th>
                             <th scope="col"><i class="fas fa-calendar-day me-2"></i>Booking Date</th>
                         </tr>
                     </thead>
                 </table>
             </div>
         </div>
     </div>
     <div class="card shadow-sm">
         <div class="card-header bg-white d-flex justify-content-between align-items-center">
             <h2 class="h4 mb-0 text-primary">
                 <i class="fas fa-user-clock me-2"></i>Custom Packages
             </h2>
         </div>

         <div class="card-body">

             <div class="table-responsive">
                 <table id="custom-packages-table" class="table table-striped table-hover">
                     <thead class="table-light">
                         <tr>
                             <th>#</th>
                             <th>Service Provider</th>
                             <th>User</th>
                             <th>Name</th>
                             <th>Price</th>
                             <th>Payment Status</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                 </table>
             </div>
         </div>
     </div>
 </div>


 <style>
     .avatar-initials {
         width: 36px;
         height: 36px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: bold;
     }

     /* Add subtle hover effect on table rows */
     .table-hover tbody tr:hover {
         background-color: rgba(13, 110, 253, 0.05);
         transition: background-color 0.2s ease;
     }

     /* Responsive adjustments */
     @media (max-width: 768px) {
         .btn-sm {
             padding: 0.25rem 0.5rem;
             font-size: 0.75rem;
         }

         th,
         td {
             padding: 0.5rem 0.75rem;
         }
     }
 </style>
