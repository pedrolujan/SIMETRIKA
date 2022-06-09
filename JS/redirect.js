/*
jQuery Redirect v1.1.3
Copyright (c) 2013-2018 Miguel Galante
Copyright (c) 2011-2013 Nemanja Avramovic, www.avramovic.info
Licencia bajo licencia CC BY-SA 4.0: http://creativecommons.org/licenses/by-sa/4.0/
Esto significa que todos pueden:
Compartir: copia y redistribuye el material en cualquier medio o formato.
Adaptar: remezclar, transformar y construir sobre el material para cualquier propósito, incluso comercialmente.
En las siguientes condiciones:
Atribución: debe otorgar el crédito correspondiente, proporcionar un enlace a la licencia e indicar si se realizaron cambios. Puede hacerlo de cualquier manera razonable, pero no de ninguna manera que sugiera que el licenciante lo respalda a usted o su uso.
ShareAlike: si remezcla, transforma o construye sobre el material, debe distribuir sus contribuciones bajo la misma licencia que el original.
*/
(function ($) {
    'use strict';
  
    //Defaults configuration
    var defaults = {
      url: null,
      values: null,
      method: "POST",
      target: null,
      traditional: false,
      redirectTop: false
    };
  
    /**
    * jQuery Redirect
    * @param {string} url - Url of the redirection
    * @param {Object} values - (optional) An object with the data to send. If not present will look for values as QueryString in the target url.
    * @param {string} method - (optional) The HTTP verb can be GET or POST (defaults to POST)
    * @param {string} target - (optional) The target of the form. "_blank" will open the url in a new window.
    * @param {boolean} traditional - (optional) This provides the same function as jquery's ajax function. The brackets are omitted on the field name if its an array.  This allows arrays to work with MVC.net among others.
    * @param {boolean} redirectTop - (optional) If its called from a iframe, force to navigate the top window. 
    *//**
    * jQuery Redirect
    * @param {string} opts - Options object
    * @param {string} opts.url - Url of the redirection
    * @param {Object} opts.values - (optional) An object with the data to send. If not present will look for values as QueryString in the target url.
    * @param {string} opts.method - (optional) The HTTP verb can be GET or POST (defaults to POST)
    * @param {string} opts.target - (optional) The target of the form. "_blank" will open the url in a new window.
    * @param {boolean} opts.traditional - (optional) This provides the same function as jquery's ajax function. The brackets are omitted on the field name if its an array.  This allows arrays to work with MVC.net among others.
    * @param {boolean} opts.redirectTop - (optional) If its called from a iframe, force to navigate the top window. 
    */
    $.redirect = function (url, values, method, target, traditional, redirectTop) {
      var opts = url;
      if (typeof url !== "object") {
        var opts = {
          url: url,
          values: values,
          method: method,
          target: target,
          traditional: traditional,
          redirectTop: redirectTop
        };
      }
  
      var config = $.extend({}, defaults, opts);
      var generatedForm = $.redirect.getForm(config.url, config.values, config.method, config.target, config.traditional);
      $('body', config.redirectTop ? window.top.document : undefined).append(generatedForm.form);
      generatedForm.submit();
      generatedForm.form.remove();
    };
  
    $.redirect.getForm = function (url, values, method, target, traditional) {
      method = (method && ["GET", "POST", "PUT", "DELETE"].indexOf(method.toUpperCase()) !== -1) ? method.toUpperCase() : 'POST';
  
      url = url.split("#");
      var hash = url[1] ? ("#" + url[1]) : "";
      url = url[0];
  
      if (!values) {
        var obj = $.parseUrl(url);
        url = obj.url;
        values = obj.params;
      }
  
      values = removeNulls(values);
  
      var form = $('<form>')
        .attr("method", method)
        .attr("action", url + hash);
  
  
      if (target) {
        form.attr("target", target);
      }
  
      var submit = form[0].submit;
      iterateValues(values, [], form, null, traditional);
  
      return { form: form, submit: function () { submit.call(form[0]); } };
    }
  
    //Utility Functions
      /**
       * Url and QueryString Parser.
       * @param {string} url - a Url to parse.
       * @returns {object} an object with the parsed url with the following structure {url: URL, params:{ KEY: VALUE }}
       */
    $.parseUrl = function (url) {
  
      if (url.indexOf('?') === -1) {
        return {
          url: url,
          params: {}
        };
      }
      var parts = url.split('?'),
        query_string = parts[1],
        elems = query_string.split('&');
      url = parts[0];
  
      var i, pair, obj = {};
      for (i = 0; i < elems.length; i += 1) {
        pair = elems[i].split('=');
        obj[pair[0]] = pair[1];
      }
  
      return {
        url: url,
        params: obj
      };
    };
  
    //Private Functions
    var getInput = function (name, value, parent, array, traditional) {
      var parentString;
      if (parent.length > 0) {
        parentString = parent[0];
        var i;
        for (i = 1; i < parent.length; i += 1) {
          parentString += "[" + parent[i] + "]";
        }
  
        if (array) {
          if (traditional)
            name = parentString;
          else
            name = parentString + "[" + name + "]";
        } else {
          name = parentString + "[" + name + "]";
        }
      }
  
      return $("<input>").attr("type", "hidden")
        .attr("name", name)
        .attr("value", value);
    };
  
    var iterateValues = function (values, parent, form, isArray, traditional) {
      var i, iterateParent = [];
      Object.keys(values).forEach(function (i) {
        if (typeof values[i] === "object") {
          iterateParent = parent.slice();
          iterateParent.push(i);
          iterateValues(values[i], iterateParent, form, Array.isArray(values[i]), traditional);
        } else {
          form.append(getInput(i, values[i], parent, isArray, traditional));
        }
      });
    };
  
    var removeNulls = function (values) {
      var propNames = Object.getOwnPropertyNames(values);
      for (var i = 0; i < propNames.length; i++) {
        var propName = propNames[i];
        if (values[propName] === null || values[propName] === undefined) {
          delete values[propName];
        } else if (typeof values[propName] === 'object') {
          values[propName] = removeNulls(values[propName]);
        } else if (values[propName].length < 1) {
          delete values[propName];
        }
      }
      return values;
    };
  }(window.jQuery || window.Zepto || window.jqlite));