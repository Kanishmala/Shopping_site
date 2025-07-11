document.addEventListener("DOMContentLoaded", () => {
  fetch("/api/get-profile")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("name").value = data.name;
      document.getElementById("email").value = data.email;
      document.getElementById("phone").value = data.phone;
      document.getElementById("address").value = data.address;
    });

  fetch("/api/get-orders")
    .then((res) => res.json())
    .then((orders) => {
      const list = document.getElementById("order-list");
      orders.forEach((order) => {
        list.innerHTML += `
          <div class="order-card">
            <strong>Order #${order.id}</strong><br>
            ${order.items.length} items - ₹${order.total}<br>
            Status: ${order.status}
          </div>
        `;
      });
    });

  document.getElementById("profile-form").addEventListener("submit", (e) => {
    e.preventDefault();
    const payload = {
      name: document.getElementById("name").value,
      email: document.getElementById("email").value,
      phone: document.getElementById("phone").value,
      address: document.getElementById("address").value,
    };

    fetch("/api/update-profile", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    })
      .then((res) => res.json())
      .then((data) => alert("Profile updated successfully!"))
      .catch((err) => alert("Error updating profile"));
  });
});
