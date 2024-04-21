const buttons = document.querySelectorAll(".likeButton")


function like(event)
{
    event.preventDefault()
    fetch(this.href)
        .then(response => response.json())
        .then((data) =>{
            this.querySelector('.nbrLikes').textContent = data.count

            let className = "bi-heart"
            let toReplace = className
            let replacement = className+"-fill"
            if(!data.liked){
                toReplace = replacement
                replacement = className
            }
            this.querySelector('.heart').classList.replace(toReplace, replacement)
        })
}
buttons.forEach((button)=>{
    button.addEventListener("click", like)
})