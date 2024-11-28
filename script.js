let partCount = 0;

function generatePart() {
    // Get form values
    const departmentCode = document.getElementById("departmentCode").value;
    const designGroup = document.getElementById("designGroup").value;
    const projectName = document.getElementById("projectName").value;
    const productGroup = document.getElementById("productGroup").value;
    const userName = document.getElementById("userName").value;
    const description = document.getElementById("description").value;

    // Generate part number and description
    const partNumber = `PN-${Math.floor(Math.random() * 10000)}`;
    const partDescription = `Desc: ${description}`;

    // Increment part count
    partCount++;

    // Create a new row in the table
    const table = document.getElementById("partTable").getElementsByTagName("tbody")[0];
    const newRow = table.insertRow();

    newRow.innerHTML = `
        <td>${partCount}</td>
        <td>${partNumber}</td>
        <td>${partDescription}</td>
        <td>${projectName}</td>
        <td>${userName}</td>
    `;

    // Clear form fields
    document.getElementById("partForm").reset();
}
