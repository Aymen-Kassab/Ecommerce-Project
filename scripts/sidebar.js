const dropdown = (dropdownId) => {
    let dropdown = document.getElementById(dropdownId);

    if(dropdown.style.display === "block"){
        dropdown.style.display = "none";
    }

    else{
        dropdown.style.display = "block";
    }
}