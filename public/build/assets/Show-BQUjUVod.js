import{a2 as z,N,af as D,a5 as O,O as x,G as d,H as i,y as t,K as r,x as y,P as G,aa as b,r as f,M as l,a4 as V,J as A,an as B,F as w,a9 as k,a3 as R,a1 as $}from"./pinia-BJ3DTyJE.js";import{O as U,o as W}from"./statuses-DNpUS0WJ.js";const q={class:"col-xl-12"},F={class:"text-start my-4 d-flex flex-wrap gap-2"},H={key:0,class:"text-center py-5"},I={key:1},M={class:"card custom-card"},L={class:"card-body d-flex flex-wrap justify-content-between align-items-center gap-3"},J={class:"mb-1"},K={class:"text-muted"},Q={class:"d-flex align-items-center gap-2"},Y=["value"],X=["disabled"],Z={class:"row"},tt={class:"col-lg-6"},et={class:"card custom-card"},st={class:"card-body"},at={class:"table table-borderless mb-0"},lt={key:0},ot={key:1},nt={class:"col-lg-6"},dt={class:"card custom-card"},it={class:"card-body"},rt={class:"d-flex align-items-center gap-2 mb-3"},ct=["src"],ut={class:"fw-bold"},pt={key:0,class:"mb-3"},mt=["href"],vt={class:"mb-1 d-flex justify-content-between"},bt={key:1,class:"mb-1 d-flex justify-content-between text-success"},ft={key:0,class:"badge bg-light text-dark ms-1"},ht={class:"mb-1 d-flex justify-content-between"},gt={class:"mb-0 d-flex justify-content-between fw-bold fs-5"},_t={class:"card custom-card"},xt={class:"card-body table-responsive"},yt={class:"table table-bordered"},wt={class:"text-center"},kt={class:"text-center"},$t={class:"text-end"},Ct=z({__name:"Show",setup(St){N({title:"Order Details"});const S=D(),E=U,s=f(null),h=f(!0),u=f("pending"),p=f(!1);function T(a){return W(a)}async function C(){h.value=!0;try{const a=await $.get(`/orders/${S.params.id}`);s.value=a.data.data,u.value=s.value.status}catch{s.value=null}finally{h.value=!1}}function o(a){return String(a??"").replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;")}function P(){const a=s.value;if(!a)return;const e=(a.items||[]).map(v=>`
        <tr>
            <td>${o(v.product_name)}</td>
            <td class="c">${o(v.quantity)}</td>
            <td class="c">${o(v.product_price)}</td>
            <td class="e">${o(v.line_total)}</td>
        </tr>`).join(""),g=Number(a.discount)>0?`<tr><td>الخصم${a.coupon_code?" ("+o(a.coupon_code)+")":""}</td><td class="e">- ${o(a.discount)} ج.م</td></tr>`:"",_=`<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<title>بوليصة شحن - ${o(a.order_number)}</title>
<style>
    * { box-sizing: border-box; }
    body { font-family: "Segoe UI", Tahoma, Arial, sans-serif; color: #111; margin: 0; padding: 16px; }
    .sheet { max-width: 800px; margin: 0 auto; border: 2px solid #111; border-radius: 8px; padding: 16px; }
    .top { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #111; padding-bottom: 10px; margin-bottom: 12px; }
    .brand { font-size: 26px; font-weight: 800; }
    .logo { height: 56px; width: auto; max-width: 200px; object-fit: contain; margin-bottom: 4px; }
    .muted { color: #555; font-size: 13px; }
    .ordno { font-size: 20px; font-weight: 800; letter-spacing: 1px; }
    h3 { margin: 14px 0 6px; font-size: 15px; border-inline-start: 4px solid #111; padding-inline-start: 8px; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .info td { padding: 6px 4px; vertical-align: top; }
    .info td.k { width: 130px; font-weight: 700; color: #333; }
    .items th, .items td { border: 1px solid #999; padding: 8px; }
    .items th { background: #f0f0f0; text-align: right; }
    .c { text-align: center; }
    .e { text-align: left; }
    .totals { margin-top: 10px; width: 320px; margin-inline-start: auto; }
    .totals td { padding: 5px 4px; }
    .totals .grand td { border-top: 2px solid #111; font-weight: 800; font-size: 17px; }
    .cod { margin-top: 14px; border: 2px dashed #111; padding: 10px; text-align: center; font-size: 18px; font-weight: 800; }
    .foot { margin-top: 22px; display: flex; justify-content: space-between; font-size: 13px; color: #333; }
    .foot div { border-top: 1px solid #999; padding-top: 6px; width: 45%; text-align: center; }
    @media print { body { padding: 0; } .sheet { border: none; } }
</style>
</head>
<body onload="window.print()">
    <div class="sheet">
        <div class="top">
            <div>
                <img src="${window.location.origin}/website/img/logo.png" alt="Pulse" class="logo" onerror="this.style.display='none'">
                <div class="muted">بوليصة شحن / Shipping Waybill</div>
            </div>
            <div style="text-align:left">
                <div class="ordno">${o(a.order_number)}</div>
                <div class="muted">${o(a.created_at)}</div>
            </div>
        </div>

        <h3>بيانات المستلم</h3>
        <table class="info">
            <tr><td class="k">الاسم</td><td>${o(a.customer_name)}</td></tr>
            <tr><td class="k">رقم الهاتف</td><td>${o(a.customer_phone)}</td></tr>
            <tr><td class="k">المحافظة</td><td>${o(a.governorate_name)}</td></tr>
            <tr><td class="k">العنوان</td><td>${o(a.address)}</td></tr>
        </table>

        <h3>المنتجات</h3>
        <table class="items">
            <thead>
                <tr><th>المنتج</th><th class="c">الكمية</th><th class="c">السعر</th><th class="e">الإجمالي</th></tr>
            </thead>
            <tbody>${e}</tbody>
        </table>

        <table class="totals">
            <tr><td>الإجمالي الفرعي</td><td class="e">${o(a.subtotal)} ج.م</td></tr>
            ${g}
            <tr><td>الشحن</td><td class="e">${o(a.shipping_price)} ج.م</td></tr>
            <tr class="grand"><td>الإجمالي</td><td class="e">${o(a.total)} ج.م</td></tr>
        </table>

        <div class="cod">
            طريقة الدفع: ${o(a.payment_method_name||"—")} — المطلوب تحصيله: ${o(a.total)} ج.م
        </div>

        <div class="foot">
            <div>توقيع المندوب</div>
        </div>
    </div>
</body>
</html>`,n=document.getElementById("waybill-print-frame");n&&n.remove();const c=document.createElement("iframe");c.id="waybill-print-frame",c.style.cssText="position:fixed;right:0;bottom:0;width:0;height:0;border:0;",document.body.appendChild(c);const m=c.contentWindow?.document;if(!m){c.remove();return}c.contentWindow?.addEventListener("afterprint",()=>{setTimeout(()=>c.remove(),300)}),m.open(),m.write(_),m.close()}async function j(){if(s.value){p.value=!0;try{const a=await $.patch(`/orders/${s.value.id}/status`,{status:u.value});s.value=a.data.data,window.showSuccessToast?.("Order status updated")}catch{window.showErrorToast?.("Failed to update status")}finally{p.value=!1}}}return O(C),(a,e)=>{const g=x("router-link"),_=x("v-progress-circular");return i(),d("div",q,[t("div",F,[y(g,{to:"/dash/orders",class:"btn btn-secondary btn-b"},{default:G(()=>[...e[1]||(e[1]=[t("i",{class:"las la-arrow-alt-circle-left"},null,-1),b(" Back to Orders ",-1)])]),_:1}),s.value?(i(),d("button",{key:0,class:"btn btn-primary btn-b",onClick:P},[...e[2]||(e[2]=[t("i",{class:"fe fe-printer me-1"},null,-1),b(" Print Waybill ",-1)])])):r("",!0)]),h.value?(i(),d("div",H,[y(_,{indeterminate:"",color:"primary"})])):s.value?(i(),d("div",I,[t("div",M,[t("div",L,[t("div",null,[t("h4",J,l(s.value.order_number),1),t("small",K,l(a.$formatDate(s.value.created_at)),1),t("span",{class:V(["badge ms-2",T(s.value.status)])},l(s.value.status_label),3)]),t("div",Q,[e[3]||(e[3]=t("label",{class:"form-label mb-0 me-2"},"Status",-1)),A(t("select",{"onUpdate:modelValue":e[0]||(e[0]=n=>u.value=n),class:"form-control",style:{width:"auto"}},[(i(!0),d(w,null,k(R(E),n=>(i(),d("option",{key:n.value,value:n.value},l(n.label),9,Y))),128))],512),[[B,u.value]]),t("button",{class:"btn btn-primary",disabled:p.value,onClick:j},l(p.value?"Saving...":"Update Status"),9,X)])])]),t("div",Z,[t("div",tt,[t("div",et,[e[10]||(e[10]=t("div",{class:"card-header"},[t("div",{class:"card-title"},"Customer Details")],-1)),t("div",st,[t("table",at,[t("tbody",null,[t("tr",null,[e[4]||(e[4]=t("th",{style:{width:"40%"}},"Name",-1)),t("td",null,l(s.value.customer_name),1)]),t("tr",null,[e[5]||(e[5]=t("th",null,"Phone",-1)),t("td",null,l(s.value.customer_phone),1)]),s.value.email?(i(),d("tr",lt,[e[6]||(e[6]=t("th",null,"Account Email",-1)),t("td",null,l(s.value.email),1)])):r("",!0),t("tr",null,[e[7]||(e[7]=t("th",null,"Governorate",-1)),t("td",null,l(s.value.governorate_name),1)]),t("tr",null,[e[8]||(e[8]=t("th",null,"Address",-1)),t("td",null,l(s.value.address),1)]),s.value.notes?(i(),d("tr",ot,[e[9]||(e[9]=t("th",null,"Notes",-1)),t("td",null,l(s.value.notes),1)])):r("",!0)])])])])]),t("div",nt,[t("div",dt,[e[16]||(e[16]=t("div",{class:"card-header"},[t("div",{class:"card-title"},"Payment & Summary")],-1)),t("div",it,[t("div",rt,[s.value.payment_method_image?(i(),d("img",{key:0,src:s.value.payment_method_image,alt:"",style:{height:"32px",width:"32px","object-fit":"contain"}},null,8,ct)):r("",!0),t("span",ut,l(s.value.payment_method_name||"—"),1)]),s.value.receipt_url?(i(),d("div",pt,[t("a",{href:s.value.receipt_url,target:"_blank",class:"btn btn-sm btn-info-light"},[...e[11]||(e[11]=[t("i",{class:"fe fe-file-text me-1"},null,-1),b(" View transfer receipt ",-1)])],8,mt)])):r("",!0),t("p",vt,[e[12]||(e[12]=t("span",null,"Subtotal",-1)),t("span",null,l(s.value.subtotal)+" EGP",1)]),Number(s.value.discount)>0?(i(),d("p",bt,[t("span",null,[e[13]||(e[13]=b("Discount ",-1)),s.value.coupon_code?(i(),d("span",ft,l(s.value.coupon_code),1)):r("",!0)]),t("span",null,"- "+l(s.value.discount)+" EGP",1)])):r("",!0),t("p",ht,[e[14]||(e[14]=t("span",null,"Shipping",-1)),t("span",null,l(s.value.shipping_price)+" EGP",1)]),t("p",gt,[e[15]||(e[15]=t("span",null,"Total",-1)),t("span",null,l(s.value.total)+" EGP",1)])])])])]),t("div",_t,[e[18]||(e[18]=t("div",{class:"card-header"},[t("div",{class:"card-title"},"Items")],-1)),t("div",xt,[t("table",yt,[e[17]||(e[17]=t("thead",null,[t("tr",null,[t("th",null,"Product"),t("th",{class:"text-center"},"Price"),t("th",{class:"text-center"},"Qty"),t("th",{class:"text-end"},"Total")])],-1)),t("tbody",null,[(i(!0),d(w,null,k(s.value.items,n=>(i(),d("tr",{key:n.id},[t("td",null,l(n.product_name),1),t("td",wt,l(n.product_price),1),t("td",kt,l(n.quantity),1),t("td",$t,l(n.line_total),1)]))),128))])])])])])):r("",!0)])}}});export{Ct as default};
