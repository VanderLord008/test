
let secondhand=document.querySelector(".second-hand");


function seconds(){
    let sectime=new Date();
let secnow=sectime.getSeconds();
    const secondsDegrees = ((secnow / 60) * 360)+90;
    secondhand.style.transform=`rotate(${secondsDegrees}deg)`;
}
setInterval(seconds, 1000); // 60 * 1000 milsec
seconds();