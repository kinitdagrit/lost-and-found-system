document.getElementById("itemForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData();
  const fullName = document.getElementById("fullName").value;
  const studentId = document.getElementById("id").value;
  const email = document.getElementById("email").value;
  const contact = document.getElementById("contact").value;
  const gender = document.getElementById("gender").value;
  const itemType = document.getElementById("itemType").value;
  const itemName = document.getElementById("itemname").value;
  const category = document.getElementById("itemCategory").value;
  const location = document.getElementById("itemLocation").value;
  const description = document.getElementById("itemDescription").value;

  formData.append("full_name", fullName);
  formData.append("student_id", studentId);
  formData.append("email", email);
  formData.append("contact", contact);
  formData.append("gender", gender);
  formData.append("item_type", itemType);
  formData.append("item_name", itemName);
  formData.append("category", category);
  formData.append("location", location);
  formData.append("description", description);

  fetch("student.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      if (data.trim() === "success") {
        const newItem = {
          fullName,
          studentId,
          email,
          contact,
          gender,
          itemType,
          itemName,
          category,
          location,
          description,
          status: itemType === "lost" ? "Unclaimed" : "Found"
        };

        const existingItems = JSON.parse(localStorage.getItem("items")) || [];
        existingItems.push(newItem);
        localStorage.setItem("items", JSON.stringify(existingItems));

        document.getElementById("itemForm").reset();
        showModal();
        loadItems();
      } else {
        alert("Server Error: " + data);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Submission failed.");
    });
});

// Load and display items from localStorage
function loadItems() {
  const items = JSON.parse(localStorage.getItem("items")) || [];
  const cardsContainer = document.getElementById("cardsContainer");
  cardsContainer.innerHTML = "";

  items.forEach((item, index) => {
    const card = document.createElement("div");
    card.className = `card ${item.itemType}`;

    let statusClass = "";
    let statusLabel = "";
    if (item.status === "Unclaimed" && item.itemType === "lost") {
      statusClass = "status-unclaimed";
      statusLabel = "Unclaimed";
    } else {
      statusClass = "status-found";
      statusLabel = "Found";
    }

    const statusAction = (item.status === "Unclaimed" && item.itemType === "lost")
      ? `<button class="markFoundBtn">Mark as Found</button>`
      : `<em>Status: Found</em>`;

    card.innerHTML = `
      <h3>${item.itemName} (${item.itemType.toUpperCase()})</h3>
      <p><strong>Posted by:</strong> ${item.fullName}</p>
      <p><strong>Student ID:</strong> ${item.studentId}</p>
      <p><strong>Email:</strong> ${item.email}</p>
      <p><strong>Contact:</strong> ${item.contact}</p>
      <p><strong>Gender:</strong> ${item.gender}</p>
      <p><strong>Category:</strong> ${item.category}</p>
      <p><strong>Location:</strong> ${item.location}</p>
      <p><strong>Description:</strong> ${item.description}</p>
      <p class="status-text ${statusClass}"><strong>Status:</strong> ${statusLabel}</p>
      ${statusAction}
      <button class="deleteBtn">Delete</button>
    `;

    if (item.status === "Unclaimed" && item.itemType === "lost") {
      card.querySelector(".markFoundBtn").addEventListener("click", function () {
        items[index].status = "Found";
        localStorage.setItem("items", JSON.stringify(items));
        loadItems();
      });
    }

    card.querySelector(".deleteBtn").addEventListener("click", function () {
      items.splice(index, 1);
      localStorage.setItem("items", JSON.stringify(items));
      loadItems();
    });

    cardsContainer.appendChild(card);
  });
}
