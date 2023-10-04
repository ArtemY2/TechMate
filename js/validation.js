const validation = new JustValidate("#signup");

validation
    .addField("#login", [
        {
            rule: "required"
        },
        {
            rule: "minLength",
            value: 5,
        },
        {
            rule: "maxLength",
            value: 15,
        },
    ])
    .addField("#name", [
        {
            rule: "required",
        },
        {
            rule: "minLength",
            value: 3,
        },
        {
            rule: "maxLength",
            value: 15,
        },
    ])
    .addField("#email", [
        {
            rule: "required",
        },
        {
            rule: "email",
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(json) {
                        return json.available;
                    });
            },
            errorMessage: "Email already taken",
        },
    ])
    
    .addField("#password", [
        {
            rule: "required",
        },
        {
            rule: "password",
        },
    ])
    .addField("#password_confirmation", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match",
        },
    ])
    .addField("#number", [
        {
            rule: "required",
        },
        {
            rule: "number",
        },
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });
