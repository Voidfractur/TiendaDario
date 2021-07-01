function moveSpan(input) {
    if(input.id == `username`) {
        document.getElementsByTagName(`label`)[0].style.borderBottom = `0.1rem solid #4285f4`;
        let span = document.getElementsByTagName(`span`)[0];
        span.style.top = `-0.8rem`;
        span.style.color = `#4285f4`;
    }
    else {
        document.getElementsByTagName(`label`)[1].style.borderBottom = `0.1rem solid #4285f4`;
        let span = document.getElementsByTagName(`span`)[1];
        span.style.top = `-0.8rem`;
        span.style.color = `#4285f4`;
    }
}
function resetSpan(input) {
    if(input.id == `username`) {
        if(input.value == ``) {
            document.getElementsByTagName(`label`)[0].style.borderBottom = `0.1rem solid silver`;
            let span = document.getElementsByTagName(`span`)[0];
            span.style.top = `1rem`;
            span.style.left = `1rem`;
            span.style.backgroundColor = ``;
            span.style.color = `silver`;
        }
    }
    else {
        if(input.value == ``) {
            document.getElementsByTagName(`label`)[1].style.borderBottom = `0.1rem solid silver`;
            let span = document.getElementsByTagName(`span`)[1];
            span.style.top = `1rem`;
            span.style.left = `1rem`;
            span.style.backgroundColor = ``;
            span.style.color = `silver`;
        }
    }
}

function focusCursor(span) {
    if(span.textContent == "USERNAME") {
        document.getElementById(`username`).focus();
    }
    else {
        document.getElementById(`password`).focus();
    }
}