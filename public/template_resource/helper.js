/**
 * Creates And Returns HTML Element
 * 
 * @param {string} element - Element To Create
 * @param {string} attrToSet - Attribute To Set
 * @param {string} attrSetting - Attributes for the attribute to set
 * @param {string} innerHTML - Text To Display
 * @param {any} value - Value to set if applicable
 * 
 * @return {html_element}
 */
function createAndSetElement(element, attrToSet, attrSetting, innerHTML = "", value = null)
{
    let htmlElement = document.createElement(element);
    htmlElement.setAttribute(attrToSet, attrSetting);
    htmlElement.innerHTML = innerHTML;
    if(value != null)htmlElement.value = value;
    return htmlElement;
}