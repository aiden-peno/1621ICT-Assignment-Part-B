function expandHamburgerMenu() {
    // display navbar
    let navBar = document.getElementById("nav-links");
    if (navBar.style.display === "block") {
        navBar.style.display = "none";
    } else {
        navBar.style.display = "block";
    }

    // toggle hamburger menu icon
    let navToggleButton = document.getElementById("nav-toggle-button");
    if (navToggleButton.className == "fa-solid fa-bars hamburger-icon") {
        navToggleButton.className = "fa-solid fa-xmark hamburger-icon";
    } else {
        navToggleButton.className = "fa-solid fa-bars hamburger-icon";
    }   

    hideSiteContent();
}

function hideSiteContent() {
    // hide main content
    let mainContent = document.getElementById("main");
    if (mainContent.style.display === "block" || mainContent.style.display === "") {
        mainContent.style.display = "none";
    } else {
        mainContent.style.display = "block";
    }

    //hide header content
    let header = document.getElementById("page-title");
    if (header.style.display === "block" || header.style.display === "") {
        header.style.display = "none";
    } else {
        header.style.display = "block";
    }

    // hide footer content
    let footer = document.getElementById("footer");
    if (footer.style.display === "block" || footer.style.display === "") {
        footer.style.display = "none";
    } else {
        footer.style.display = "block";
    }
}

function collapseCommunityPostForm() {
    // toggle form content
    let formContent = document.getElementById("community-post-form");
    if (formContent.className === "display-block") {
        formContent.className = "display-none";
    } else {
        formContent.className = "display-block";
    }

    // toggle chevron icon
    // toggle hamburger menu icon
    let formToggleChevron = document.getElementById("community-post-form-toggle-button");
    if (formToggleChevron.className == "fa-solid fa-chevron-right") {
        formToggleChevron.className = "fa-solid fa-chevron-down";
    } else {
        formToggleChevron.className = "fa-solid fa-chevron-right";
    }   
}

function collapseCommunitySearchForm() {
    // toggle form content
    let formContent = document.getElementById("community-search-form");
    if (formContent.className === "display-block") {
        formContent.className = "display-none";
    } else {
        formContent.className = "display-block";
    }

    // toggle chevron icon
    // toggle hamburger menu icon
    let formToggleChevron = document.getElementById("community-search-form-toggle-button");
    if (formToggleChevron.className == "fa-solid fa-chevron-right") {
        formToggleChevron.className = "fa-solid fa-chevron-down";
    } else {
        formToggleChevron.className = "fa-solid fa-chevron-right";
    }   
}

function verifyPassword() {
    password = document.getElementById("password");
    confirmPassword = document.getElementById("confirm-password");
    validationParagraph = document.getElementById("password-valid-p");
    if (password.value !== confirmPassword.value) {
        validationParagraph.innerHTML = "**Entered passwords do not match, please ensure they match.";
        password.className = "error-field";
        confirmPassword.className = "error-field";
        return false;
    } else {
        password.className = "";
        confirmPassword.className = "";
        validationParagraph.innerHTML = "";
    }
    return true;
}

function populateJoinSelects() {
    // country of birth and nationality
    let cob_dropdown = $('#birth_country');
    let nat_dropdown = $('#nationality');
    const nations_url = './json/countries-nationalities.json';
    $.getJSON(nations_url, function (data) {
        $.each(data, function (key, entry) {
            cob_dropdown.append($('<option></option>').attr('value', entry.country_name).text(entry.country_name));
            nat_dropdown.append($('<option></option>').attr('value', entry.nationality).text(entry.nationality));
        })
    });

    // languages
    let lang_dropdown = $('#spoken_language');
    const language_url = './json/languages.json';
    $.getJSON(language_url, function (data) {
        $.each(data, function (key, entry) {
            lang_dropdown.append($('<option></option>').attr('value', entry.name).text(entry.name));
        })
    });
}

function checkEmailExists() {
    emailMessage = document.getElementById("email-valid-p");
    emailField = document.getElementById("email");
    submitButton = document.getElementById("submit-button");

    email = emailField.value;
    if (email !== "") {
        // call php via ajax
        jQuery.ajax({
            type: "POST",
            url: './db/checkUser.php',
            dataType: 'json',
            data: {functionname: 'checkUserExists', arguments: [email]},
        
            success: function (obj, textstatus) {
                if (!obj.result) {
                    //user doesn't exist, don't do anything
                    emailMessage.innerHTML = "";
                    emailField.className = "";
                    submitButton.disabled = false;
                } else {
                    emailMessage.innerHTML = "You already have an account, log in <a href='./account.php'>here</a>.";
                    emailField.className = "error-field";
                    submitButton.disabled = true;
                }
            },
            error: function (obj1, str, obj2){
                // document.body.innerHTML = obj1.responseText;
                console.log(obj1.responseText);
                console.log(str);
            }
        });
    }
}

function toggleSpokenLanguage() {
    englishSpoken = document.getElementById("english_spoken_language");
    label = document.getElementById("spoken-language-label");
    input = document.getElementById("spoken_language");

    if (englishSpoken.value == "No") {
        label.className = "display-block";
        input.className = "display-block";
        input.required = true;     
    } else {
        label.className = "display-none";
        input.className = "display-none";
        input.value = "";
        input.required = false;
    }
}

function clearUrl(url) {
    window.location.href = url;
}

// function retrieveDrawInfo(team) {
//     // call php via ajax
//     jQuery.ajax({
//         type: "POST",
//         url: './db/draw.php',
//         data: {team: [team]}
    
//         // success: function (obj, textstatus) {
            
//         // },
//         // error: function (obj1, str, obj2){
            
//         // }
//     });
// }