export default {
    inserted: el =>{
        function loadImage(){
            el.style = `background-image: url(${el.dataset.src})`;
            console.log(el.dataset.src)
            console.log(el.style)
        }

        function callback(entries, observer){
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    loadImage();
                    observer.unobserve(el)
                }
            })
        }

        function createIntersectionObserver(){
            const options = {
                root: null,
                threshold: 0,
            }

            const observer = new IntersectionObserver(callback, options)
            observer.observe(el)
        }

        if(!window['IntersectionObserver'])
            loadImage();
        else{
            createIntersectionObserver();
        }
    },



}

