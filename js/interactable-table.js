// Select all the cells in your table
let cells = document.querySelectorAll('td');

// Loop through each cell
cells.forEach(cell => {

    // Add a click event listener to the cell
    cell.addEventListener('click', function() {
        // Save the current cell content
        let cellContent = this.innerHTML;

        // Replace the cell content with an input element
        this.innerHTML = `<input type="text" value="${cellContent}">`;

        // Select the input element
        let input = this.querySelector('input');

        // Focus the input element
        input.focus();

        // Add a blur event listener to the input element
        input.addEventListener('blur', function() {
            // Replace the input element with its current value
            cell.innerHTML = this.value;
        });
    });
});
