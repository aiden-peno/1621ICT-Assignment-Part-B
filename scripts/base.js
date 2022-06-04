function expandHamburgerMenu() {
    // toggle mobile nav bar display
    let navBar = document.getElementById("nav-links");
    if (navBar.style.display === "block") {
        navBar.style.display = "none";
    } else {
        navBar.style.display = "block";
    }

    // toggle hamburger menu icon from bars to cross when expanding menu
    let navToggleButton = document.getElementById("nav-toggle-button");
    if (navToggleButton.className == "fa-solid fa-bars hamburger-icon") {
        navToggleButton.className = "fa-solid fa-xmark hamburger-icon";
    } else {
        navToggleButton.className = "fa-solid fa-bars hamburger-icon";
    }

    // hide all site content so the nav links are all the user sees
    hideSiteContent();
}

function hideSiteContent() {
    // toggle display of main content
    let mainContent = document.getElementById("main");
    if (mainContent.style.display === "block" || mainContent.style.display === "") {
        mainContent.style.display = "none";
    } else {
        mainContent.style.display = "block";
    }

    //toggle display of header content
    let header = document.getElementById("page-title");
    if (header.style.display === "block" || header.style.display === "") {
        header.style.display = "none";
    } else {
        header.style.display = "block";
    }

    // toggle display of footer content
    let footer = document.getElementById("footer");
    if (footer.style.display === "block" || footer.style.display === "") {
        footer.style.display = "none";
    } else {
        footer.style.display = "block";
    }
}

function collapseCommunityPostForm() {
    // toggle display of form content
    let formContent = document.getElementById("community-post-form");
    if (formContent.className === "display-block") {
        formContent.className = "display-none";
    } else {
        formContent.className = "display-block";
    }

    // toggle chevron icon from point right to point down
    let formToggleChevron = document.getElementById("community-post-form-toggle-button");
    if (formToggleChevron.className == "fa-solid fa-chevron-right") {
        formToggleChevron.className = "fa-solid fa-chevron-down";
    } else {
        formToggleChevron.className = "fa-solid fa-chevron-right";
    }
}

function collapseCommunitySearchForm() {
    // toggle display of form content
    let formContent = document.getElementById("community-search-form");
    if (formContent.className === "display-block") {
        formContent.className = "display-none";
    } else {
        formContent.className = "display-block";
    }

    // toggle chevron icon from point right to point down
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
    // if password is each field is different, return false and display error message
    if (password.value !== confirmPassword.value) {
        validationParagraph.innerHTML = "**Entered passwords do not match, please ensure they match.";
        password.className = "error-field";
        confirmPassword.className = "error-field";
        return false;
    } else {
        // else ensure error message is not displaying
        password.className = "";
        confirmPassword.className = "";
        validationParagraph.innerHTML = "";
    }
    // return true if password in both fields match
    return true;
}

function populateJoinSelects() {
    // populates country of birth and nationality dropdowns on join page
    let cob_dropdown = $('#birth_country');
    let nat_dropdown = $('#nationality');
    const nations_url = './json/countries-nationalities.json';
    // retrieves JSON via ajax call
    $.getJSON(nations_url, function (data) {
        $.each(data, function (key, entry) {
            cob_dropdown.append($('<option></option>').attr('value', entry.country_name).text(entry.country_name));
            nat_dropdown.append($('<option></option>').attr('value', entry.nationality).text(entry.nationality));
        })
    });

    // populates languages dropdown on join page
    let lang_dropdown = $('#spoken_language');
    const language_url = './json/languages.json';
    // retrieves JSON via ajax call
    $.getJSON(language_url, function (data) {
        $.each(data, function (key, entry) {
            lang_dropdown.append($('<option></option>').attr('value', entry.name).text(entry.name));
        })
    });
}

// checks if the email entered in the join page already exists in the DB
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
            data: { functionname: 'checkUserExists', arguments: [email] },

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
            error: function (obj1, str, obj2) {
                // document.body.innerHTML = obj1.responseText;
                console.log(obj1.responseText);
                console.log(str);
            }
        });
    }
}

// if spoken language is not English, display dropdown for spoken language selection
function toggleSpokenLanguage() {
    englishSpoken = document.getElementById("english_spoken_language");
    label = document.getElementById("spoken-language-label");
    input = document.getElementById("spoken_language");

    // toggles visibility of spoken language field
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

function toggleAndResetDetailsForm(callingElement) {
    detailsElement = document.getElementById("basic-details-div");
    detailsLink = document.getElementById("basic-details-update-link");
    detailsFormElement = document.getElementById("basic-details-form");

    // toggles visibility of spoken language field
    if (detailsElement.className == "display-block" || detailsElement.className == "") {
        detailsElement.className = "display-none";
        detailsLink.className = "display-none";
        detailsFormElement.className = "display-block";
    } else {
        detailsElement.className = "display-block";
        detailsLink.className = "display-block";
        detailsFormElement.className = "display-none";
    }

    // if clicked from reset button, reset form fields
    if (callingElement) {
        firstNameField = document.getElementById("first-name");
        lastNameField = document.getElementById("last-name");
        phoneNumberField = document.getElementById("phone-number");

        firstNameField.value = "";
        lastNameField.value = "";
        phoneNumberField.value = "";
    }
}

// simulates navigation to passed in url
function clearUrl(url) {
    window.location.href = url;
}
