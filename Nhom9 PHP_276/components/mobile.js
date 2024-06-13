const btnNavmobile = document.querySelector('.btn_navmobile');
const bannerMobilenav = document.querySelector('.header__mobilenav-func');
btnNavmobile.addEventListener('click',()=>{
    if(bannerMobilenav.classList.contains('show')){
        bannerMobilenav.classList.remove('show');
    }else{
        bannerMobilenav.classList.add('show');
    }
})