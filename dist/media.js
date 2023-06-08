(()=>{"use strict";const t=window.wp.i18n,{get:e}=lodash,a=({button:a,endpoint:n,callback:i=!1,buttonText:s=(0,t.__)("Rescan","classifai")})=>{const c=a.getAttribute("data-id"),[d]=a.parentNode.getElementsByClassName("spinner"),[l]=a.parentNode.getElementsByClassName("error"),o=`${n}${c}`;a.setAttribute("disabled","disabled"),d.style.display="inline-block",d.classList.add("is-active"),l.style.display="none",wp.apiRequest({path:o}).then((t=>{a.removeAttribute("disabled"),d.style.display="none",d.classList.remove("is-active"),a.textContent=s,i&&i(t)}),(n=>{const i=e(n,"responseJSON",{code:"unknown_error",message:(0,t.__)("An unknown error occurred.","classifai")});d.style.display="none",d.classList.remove("is-active"),a.removeAttribute("disabled"),a.textContent=s,l.style.display="inline-block",l.textContent=`Error: ${i.message}`}))};!function(e){const n=()=>{const e=document.getElementById("classifai-rescan-alt-tags"),n=document.getElementById("classifai-rescan-image-tags"),i=document.getElementById("classifai-rescan-ocr"),s=document.getElementById("classifai-rescan-smart-crop"),c=document.getElementById("classifai-rescan-pdf"),d=document.getElementById("classifai-retranscribe");e&&e.addEventListener("click",(t=>a({button:t.target,endpoint:"/classifai/v1/alt-tags/",callback:t=>{const{enabledAltTextFields:e}=classifaiMediaVars;if(t){if(e.includes("alt")){var a;const e=null!==(a=document.getElementById("attachment-details-two-column-alt-text"))&&void 0!==a?a:document.getElementById("attachment-details-alt-text");e&&(e.value=t)}if(e.includes("caption")){var n;const e=null!==(n=document.getElementById("attachment-details-two-column-caption"))&&void 0!==n?n:document.getElementById("attachment-details-caption");e&&(e.value=t)}if(e.includes("description")){var i;const e=null!==(i=document.getElementById("attachment-details-two-column-description"))&&void 0!==i?i:document.getElementById("attachment-details-description");e&&(e.value=t)}}}}))),n&&n.addEventListener("click",(t=>a({button:t.target,endpoint:"/classifai/v1/image-tags/"}))),i&&i.addEventListener("click",(t=>a({button:t.target,endpoint:"/classifai/v1/ocr/",callback:t=>{if(t){var e;const a=null!==(e=document.getElementById("attachment-details-two-column-description"))&&void 0!==e?e:document.getElementById("attachment-details-description");a&&(a.value=t)}}}))),s&&s.addEventListener("click",(t=>a({button:t.target,endpoint:"/classifai/v1/smart-crop/"}))),c&&c.addEventListener("click",(e=>{const a=e.target.getAttribute("data-id");wp.apiRequest({path:`/classifai/v1/read-pdf/${a}`}),e.target.setAttribute("disabled","disabled"),e.target.textContent=(0,t.__)("Read API requested!","classifai")})),d&&d.addEventListener("click",(e=>a({button:e.target,endpoint:"/classifai/v1/openai/generate-transcript/",callback:t=>{if(t){var e;const a=null!==(e=document.getElementById("attachment-details-two-column-description"))&&void 0!==e?e:document.getElementById("attachment-details-description");a&&(a.value=t)}},buttonText:(0,t.__)("Re-transcribe","classifai")})))},i=()=>{const a=document.getElementById("classifai-rescan-pdf");if(!a)return;const n=a.getAttribute("data-id");e.ajax({url:ajaxurl,type:"POST",data:{action:"classifai_get_read_status",attachment_id:n,nonce:ClassifAI.ajax_nonce},success:e=>{e?.success&&(e?.data?.running?(a.setAttribute("disabled","disabled"),a.textContent=(0,t.__)("In progress!","classifai")):e?.data?.read&&(a.textContent=(0,t.__)("Rescan","classifai")))}})};e(document).ready((function(){wp.media&&wp.media.view.Modal.prototype.on("open",(function(){wp.media.frame.on("selection:toggle",n),wp.media.frame.on("selection:toggle",i)})),wp.media.frame&&(wp.media.frame.on("edit:attachment",n),wp.media.frame.on("edit:attachment",i)),wp.Uploader&&wp.Uploader.queue&&wp.Uploader.queue.on("reset",n)}))}(jQuery)})();