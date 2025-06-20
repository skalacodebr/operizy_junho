/*
 CookieConsent v2.8.0
 https://www.github.com/orestbida/cookieconsent
 Author Orest Bida
 Released under the MIT License
*/

(function () {
    var kb = function (eb) {
        var e = {
                mode: "opt-in",
                current_lang: "en",
                auto_language: null,
                autorun: !0,
                cookie_name: "cc_cookie",
                cookie_expiration: 182,
                cookie_domain: window.location.hostname,
                cookie_path: "/",
                cookie_same_site: "Lax",
                use_rfc_cookie: !1,
                autoclear_cookies: !0,
                revision: 0,
                script_selector: "data-cookiecategory"
            },
            m = {},
            g, t = {},
            C = null,
            K = !1,
            Q = !1,
            na = !1,
            Ca = !1,
            oa = !1,
            v, Y, U, pa, Da, Ea, Fa = !1,
            Z = !0,
            Sa = "",
            V = [],
            xa = !1,
            Ga, Ha = [],
            Ta = [],
            Ia = [],
            Ua = !1,
            qa, Ja, Ka = [],
            ja = [],
            R = [],
            I = [],
            ya = [],
            ra = document.documentElement,
            L, sa, x, aa,
            ta, W, S, T, ba, E, M, ua, ka, la, y, ca, da, ea, fa, Va = function (a) {
                function b(n) {
                    return (a || document).querySelectorAll('a[data-cc="' + n + '"], button[data-cc="' + n + '"]')
                }

                function c(n, p) {
                    n.preventDefault ? n.preventDefault() : n.returnValue = !1;
                    m.accept(p);
                    m.hideSettings();
                    m.hide()
                }
                for (var d = b("c-settings"), f = b("accept-all"), l = b("accept-necessary"), q = b("accept-selection"), h = 0; h < d.length; h++) d[h].setAttribute("aria-haspopup", "dialog"), z(d[h], "click", function (n) {
                    n.preventDefault ? n.preventDefault() : n.returnValue = !1;
                    m.showSettings(0)
                });
                for (h = 0; h < f.length; h++) z(f[h], "click", function (n) {
                    c(n, "all")
                });
                for (h = 0; h < q.length; h++) z(q[h], "click", function (n) {
                    c(n)
                });
                for (h = 0; h < l.length; h++) z(l[h], "click", function (n) {
                    c(n, [])
                })
            },
            za = function (a, b) {
                if (Object.prototype.hasOwnProperty.call(b, a)) return a;
                if (0 < va(b).length) return Object.prototype.hasOwnProperty.call(b, e.current_lang) ? e.current_lang : va(b)[0]
            },
            Wa = function () {
                function a(c, d) {
                    var f = !1,
                        l = !1;
                    try {
                        for (var q = c.querySelectorAll(b.join(':not([tabindex="-1"]), ')), h, n = q.length, p = 0; p < n;) h = q[p].getAttribute("data-focus"),
                            l || "1" !== h ? "0" === h && (f = q[p], l || "0" === q[p + 1].getAttribute("data-focus") || (l = q[p + 1])) : l = q[p], p++
                    } catch (F) {
                        return c.querySelectorAll(b.join(", "))
                    }
                    d[0] = q[0];
                    d[1] = q[q.length - 1];
                    d[2] = f;
                    d[3] = l
                }
                var b = ["[href]", "button", "input", "details", '[tabindex="0"]'];
                a(M, ja);
                Q && a(x, Ka)
            },
            La = function (a) {
                !0 === g.force_consent && J(ra, "force--consent");
                if (!x) {
                    x = k("div");
                    var b = k("div"),
                        c = k("div");
                    x.id = "cm";
                    b.id = "c-inr-i";
                    c.id = "cm-ov";
                    x.setAttribute("role", "dialog");
                    x.setAttribute("aria-modal", "true");
                    x.setAttribute("aria-hidden",
                        "false");
                    x.setAttribute("aria-labelledby", "c-ttl");
                    x.setAttribute("aria-describedby", "c-txt");
                    sa.appendChild(x);
                    sa.appendChild(c);
                    x.style.visibility = c.style.visibility = "hidden";
                    c.style.opacity = 0
                }
                if (c = g.languages[a].consent_modal.title) aa || (aa = k("div"), aa.id = "c-ttl", aa.setAttribute("role", "heading"), aa.setAttribute("aria-level", "2"), b.appendChild(aa)), aa.innerHTML = c;
                c = g.languages[a].consent_modal.description;
                Fa && (c = Z ? c.replace("{{revision_message}}", "") : c.replace("{{revision_message}}", Sa || g.languages[a].consent_modal.revision_message ||
                    ""));
                ta || (ta = k("div"), ta.id = "c-txt", b.appendChild(ta));
                ta.innerHTML = c;
                c = g.languages[a].consent_modal.primary_btn;
                var d = g.languages[a].consent_modal.secondary_btn;
                if (c) {
                    if (!W) {
                        W = k("button");
                        W.id = "c-p-bn";
                        W.className = "c-bn ";
                        var f;
                        "accept_all" === c.role && (f = "all");
                        z(W, "click", function () {
                            m.hide();
                            m.accept(f)
                        })
                    }
                    W.textContent = g.languages[a].consent_modal.primary_btn.text
                }

                d && (S || (S = k("button"), S.id = "c-s-bn", S.className = "c-bn c_link", "accept_necessary" === d.role ? z(S, "click", function () {
                        m.hide();
                        m.accept([])
                    }) :
                    z(S, "click", function () {
                        m.showSettings(0)
                    })), S.textContent = g.languages[a].consent_modal.secondary_btn.text);

                a = g.gui_options;
                ba || (ba = k("div"), ba.id = "c-inr", ba.appendChild(b));
                T || (T = k("div"), T.id = "c-bns", a && a.consent_modal && !0 === a.consent_modal.swap_buttons ? (d && T.appendChild(S), c && T.appendChild(W), T.className = "swap") : (c && T.appendChild(W), d && T.appendChild(S)), (c || d) && ba.appendChild(T), x.appendChild(ba));
                Q = !0
            },
            ab = function (a) {
                if (E) y = k("div"), y.id = "s-bl";
                else {
                    E = k("div");
                    var b = k("div"),
                        c = k("div"),
                        d = k("div");
                    M = k("div");
                    ua = k("div");
                    var f = k("div");
                    ka = k("button");
                    var l = k("div");
                    la = k("div");
                    var q = k("div");
                    E.id = "s-cnt";
                    b.id = "c-vln";
                    d.id = "c-s-in";
                    c.id = "cs";
                    ua.id = "s-ttl";
                    M.id = "s-inr";
                    f.id = "s-hdr";
                    la.id = "s-bl";
                    ka.id = "s-c-bn";
                    q.id = "cs-ov";
                    l.id = "s-c-bnc";
                    ka.className = "c-bn ";
                    E.setAttribute("role", "dialog");
                    E.setAttribute("aria-modal", "true");
                    E.setAttribute("aria-hidden", "true");
                    E.setAttribute("aria-labelledby", "s-ttl");
                    ua.setAttribute("role", "heading");
                    E.style.visibility = q.style.visibility = "hidden";
                    q.style.opacity =
                        0;
                    l.appendChild(ka);
                    z(b, "keydown", function (ma) {
                        ma = ma || window.event;
                        27 === ma.keyCode && m.hideSettings(0)
                    }, !0);
                    z(ka, "click", function () {
                        m.hideSettings(0)
                    })
                }
                ka.setAttribute("aria-label", g.languages[a].settings_modal.close_btn_label || "Close");
                U = g.languages[a].settings_modal.blocks;
                Y = g.languages[a].settings_modal.cookie_table_headers;
                var h = U.length;
                ua.innerHTML = g.languages[a].settings_modal.title;
                for (var n = 0; n < h; ++n) {
                    var p = U[n].title,
                        F = U[n].description,
                        w = U[n].toggle,
                        A = U[n].cookie_table,
                        u = !0 === g.remove_cookie_tables,
                        r = F && "truthy" || !u && A && "truthy",
                        B = k("div"),
                        X = k("div");
                    if (F) {
                        var Ma = k("div");
                        Ma.className = "p";
                        Ma.insertAdjacentHTML("beforeend", F)
                    }
                    var D = k("div");
                    D.className = "title";
                    B.className = "c-bl";
                    X.className = "desc";
                    if ("undefined" !== typeof w) {
                        var N = "c-ac-" + n,
                            ha = r ? k("button") : k("div"),
                            G = k("label"),
                            O = k("input"),
                            P = k("span"),
                            ia = k("span"),
                            Xa = k("span"),
                            Ya = k("span");
                        ha.className = r ? "b-tl exp" : "b-tl";
                        G.className = "b-tg";
                        O.className = "c-tgl";
                        Xa.className = "on-i";
                        Ya.className = "off-i";
                        P.className = "c-tg";
                        ia.className = "t-lb";
                        r &&
                            (ha.setAttribute("aria-expanded", "false"), ha.setAttribute("aria-controls", N));
                        O.type = "checkbox";
                        P.setAttribute("aria-hidden", "true");
                        var Aa = w.value;
                        O.value = Aa;
                        ia.textContent = p;
                        ha.insertAdjacentHTML("beforeend", p);
                        D.appendChild(ha);
                        P.appendChild(Xa);
                        P.appendChild(Ya);
                        K ? -1 < H(t.level, Aa) ? (O.checked = !0, !y && R.push(!0)) : !y && R.push(!1) : w.enabled ? (O.checked = !0, !y && R.push(!0), w.enabled && !y && Ia.push(Aa)) : !y && R.push(!1);
                        !y && I.push(Aa);
                        w.readonly ? (O.disabled = !0, J(P, "c-ro"), !y && ya.push(!0)) : !y && ya.push(!1);
                        J(X,
                            "b-acc");
                        J(D, "b-bn");
                        J(B, "b-ex");
                        X.id = N;
                        X.setAttribute("aria-hidden", "true");
                        G.appendChild(O);
                        G.appendChild(P);
                        G.appendChild(ia);
                        D.appendChild(G);
                        r && function (ma, Na, Za) {
                            z(ha, "click", function () {
                                $a(Na, "act") ? (Oa(Na, "act"), Za.setAttribute("aria-expanded", "false"), ma.setAttribute("aria-hidden", "true")) : (J(Na, "act"), Za.setAttribute("aria-expanded", "true"), ma.setAttribute("aria-hidden", "false"))
                            }, !1)
                        }(X, B, ha)
                    } else p && (r = k("div"), r.className = "b-tl", r.setAttribute("role", "heading"), r.setAttribute("aria-level",
                        "3"), r.insertAdjacentHTML("beforeend", p), D.appendChild(r));
                    p && B.appendChild(D);
                    F && X.appendChild(Ma);
                    if (!u && "undefined" !== typeof A) {
                        r = document.createDocumentFragment();
                        for (N = 0; N < Y.length; ++N) G = k("th"), u = Y[N], G.setAttribute("scope", "col"), u && (D = u && va(u)[0], G.textContent = Y[N][D], r.appendChild(G));
                        u = k("tr");
                        u.appendChild(r);
                        D = k("thead");
                        D.appendChild(u);
                        r = k("table");
                        r.appendChild(D);
                        N = document.createDocumentFragment();
                        for (G = 0; G < A.length; G++) {
                            O = k("tr");
                            for (P = 0; P < Y.length; ++P)
                                if (u = Y[P]) D = va(u)[0], ia = k("td"),
                                    ia.insertAdjacentHTML("beforeend", A[G][D]), ia.setAttribute("data-column", u[D]), O.appendChild(ia);
                            N.appendChild(O)
                        }
                        A = k("tbody");
                        A.appendChild(N);
                        r.appendChild(A);
                        X.appendChild(r)
                    }
                    if (w && p || !w && (p || F)) B.appendChild(X), y ? y.appendChild(B) : la.appendChild(B)
                }
                ca || (ca = k("div"), ca.id = "s-bns");
                ea || (ea = k("button"), ea.id = "s-all-bn", ea.className = "c-bn ", ca.appendChild(ea), z(ea, "click", function () {
                    m.hideSettings();
                    m.hide();
                    m.accept("all")
                }));
                ea.textContent = g.languages[a].settings_modal.accept_all_btn;
                if (h = g.languages[a].settings_modal.reject_all_btn) fa ||
                    (fa = k("button"), fa.id = "s-rall-bn", fa.className = "c-bn ", z(fa, "click", function () {
                        m.hideSettings();
                        m.hide();
                        m.accept([])
                    }), M.className = "bns-t", ca.appendChild(fa)), fa.textContent = h;

                da || (da = k("button"), da.className = "c-bn d-none", ca.appendChild(da), z(da, "click", function () {
                    m.hideSettings();
                    m.hide();
                    m.accept()
                }));
                da.textContent = g.languages[a].settings_modal.save_settings_btn;
                y ? (M.replaceChild(y, la), la = y) : (f.appendChild(ua), f.appendChild(l), M.appendChild(f), M.appendChild(la), M.appendChild(ca), d.appendChild(M),
                    c.appendChild(d), b.appendChild(c), E.appendChild(b), sa.appendChild(E), sa.appendChild(q))
            },
            fb = function () {
                
            };
        m.updateLanguage = function (a, b) {
            if ("string" ===
                typeof a) return a = za(a, g.languages), a !== e.current_lang || !0 === b ? (e.current_lang = a, Q && (La(a), Va(ba)), ab(a), !0) : !1
        };
        var cb = function (a) {
                var b = U.length,
                    c = -1;
                xa = !1;
                var d = wa("", "all"),
                    f = [e.cookie_domain, "." + e.cookie_domain];
                if ("www." === e.cookie_domain.slice(0, 4)) {
                    var l = e.cookie_domain.substr(4);
                    f.push(l);
                    f.push("." + l)
                }
                for (l = 0; l < b; l++) {
                    var q = U[l];
                    if (Object.prototype.hasOwnProperty.call(q, "toggle")) {
                        var h = -1 < H(V, q.toggle.value);
                        if (!R[++c] && Object.prototype.hasOwnProperty.call(q, "cookie_table") && (a || h)) {
                            var n =
                                q.cookie_table,
                                p = va(Y[0])[0],
                                F = n.length;
                            "on_disable" === q.toggle.reload && h && (xa = !0);
                            for (h = 0; h < F; h++) {
                                var w = n[h],
                                    A = [],
                                    u = w[p],
                                    r = w.is_regex || !1,
                                    B = w.domain || null;
                                w = w.path || !1;
                                B && (f = [B, "." + B]);
                                if (r)
                                    for (r = 0; r < d.length; r++) d[r].match(u) && A.push(d[r]);
                                else u = H(d, u), -1 < u && A.push(d[u]);
                                0 < A.length && (bb(A, w, f), "on_clear" === q.toggle.reload && (xa = !0))
                            }
                        }
                    }
                }
            },
            gb = function (a) {
                V = [];
                var b = document.querySelectorAll(".c-tgl") || [];
                if (0 < b.length)
                    for (var c = 0; c < b.length; c++) - 1 !== H(a, I[c]) ? (b[c].checked = !0, R[c] || (V.push(I[c]),
                        R[c] = !0)) : (b[c].checked = !1, R[c] && (V.push(I[c]), R[c] = !1));
                K && e.autoclear_cookies && 0 < V.length && cb();
                t = {
                    level: a,
                    revision: e.revision,
                    data: C,
                    rfc_cookie: e.use_rfc_cookie
                };
                if (!K || 0 < V.length || !Z) Z = !0, Ga = Pa(Qa()), Ra(e.cookie_name, JSON.stringify(t)), Ba();
                if (!K && (e.autoclear_cookies && cb(!0), "function" === typeof Ea && Ea(m.getUserPreferences(), t), "function" === typeof pa && pa(t), K = !0, "opt-in" === e.mode)) return;
                "function" === typeof Da && 0 < V.length && Da(t, V);
                xa && window.location.reload()
            },
            hb = function (a, b) {
                if ("string" !== typeof a ||
                    "" === a || document.getElementById("cc--style")) b();
                else {
                    var c = k("style");
                    c.id = "cc--style";
                    var d = new XMLHttpRequest;
                    d.onreadystatechange = function () {
                        4 === this.readyState && 200 === this.status && (c.setAttribute("type", "text/css"), c.styleSheet ? c.styleSheet.cssText = this.responseText : c.appendChild(document.createTextNode(this.responseText)), document.getElementsByTagName("head")[0].appendChild(c), b())
                    };
                    d.open("GET", a);
                    d.send()
                }
            },
            H = function (a, b) {
                for (var c = a.length, d = 0; d < c; d++)
                    if (a[d] === b) return d;
                return -1
            },
            k = function (a) {
                var b =
                    document.createElement(a);
                "button" === a && b.setAttribute("type", a);
                return b
            },
            ib = function (a, b) {
                return "browser" === e.auto_language ? (b = navigator.language || navigator.browserLanguage, 2 < b.length && (b = b[0] + b[1]), b = b.toLowerCase(), za(b, a)) : "document" === e.auto_language ? za(document.documentElement.lang, a) : "string" === typeof b ? e.current_lang = za(b, a) : e.current_lang
            },
            jb = function () {
                var a = !1,
                    b = !1;
                z(document, "keydown", function (c) {
                    c = c || window.event;
                    "Tab" === c.key && (v && (c.shiftKey ? document.activeElement === v[0] && (v[1].focus(),
                        c.preventDefault()) : document.activeElement === v[1] && (v[0].focus(), c.preventDefault()), b || oa || (b = !0, !a && c.preventDefault(), c.shiftKey ? v[3] ? v[2] ? v[2].focus() : v[0].focus() : v[1].focus() : v[3] ? v[3].focus() : v[0].focus())), !b && (a = !0))
                });
                document.contains && z(L, "click", function (c) {
                    c = c || window.event;
                    Ca ? M.contains(c.target) ? oa = !0 : (m.hideSettings(0), oa = !1) : na && x.contains(c.target) && (oa = !0)
                }, !0)
            },
            db = function (a, b) {
                function c(f, l, q, h, n, p, F) {
                    p = p && p.split(" ") || [];
                    if (-1 < H(l, n) && (J(f, n), ("bar" !== n || "middle" !== p[0]) &&
                            -1 < H(q, p[0])))
                        for (l = 0; l < p.length; l++) J(f, p[l]); - 1 < H(h, F) && J(f, F)
                }
                if ("object" === typeof a) {
                    var d = a.consent_modal;
                    a = a.settings_modal;
                    Q && d && c(x, ["box", "bar", "cloud"], ["top", "middle", "bottom"], ["zoom", "slide"], d.layout, d.position, d.transition);
                    !b && a && c(E, ["bar"], ["left", "right"], ["zoom", "slide"], a.layout, a.position, a.transition)
                }
            };
        m.allowedCategory = function (a) {
            var b = K || "opt-in" === e.mode ? JSON.parse(wa(e.cookie_name, "one", !0) || "{}").level || [] : Ia;
            return -1 < H(b, a)
        };
        m.run = function (a) {
            if (!document.getElementById("cc_div") &&
                (g = a, "number" === typeof g.cookie_expiration && (e.cookie_expiration = g.cookie_expiration), "number" === typeof g.cookie_necessary_only_expiration && (e.cookie_necessary_only_expiration = g.cookie_necessary_only_expiration), "boolean" === typeof g.autorun && (e.autorun = g.autorun), "string" === typeof g.cookie_domain && (e.cookie_domain = g.cookie_domain), "string" === typeof g.cookie_same_site && (e.cookie_same_site = g.cookie_same_site), "string" === typeof g.cookie_path && (e.cookie_path = g.cookie_path), "string" === typeof g.cookie_name &&
                    (e.cookie_name = g.cookie_name), "function" === typeof g.onAccept && (pa = g.onAccept), "function" === typeof g.onFirstAction && (Ea = g.onFirstAction), "function" === typeof g.onChange && (Da = g.onChange), "opt-out" === g.mode && (e.mode = "opt-out"), "number" === typeof g.revision && (-1 < g.revision && (e.revision = g.revision), Fa = !0), "boolean" === typeof g.autoclear_cookies && (e.autoclear_cookies = g.autoclear_cookies), !0 === g.use_rfc_cookie && (e.use_rfc_cookie = !0), !0 === g.hide_from_bots && (Ua = navigator && (navigator.userAgent && /bot|crawl|spider|slurp|teoma/i.test(navigator.userAgent) ||
                        navigator.webdriver)), e.page_scripts = !0 === g.page_scripts, e.page_scripts_order = !1 !== g.page_scripts_order, "browser" === g.auto_language || !0 === g.auto_language ? e.auto_language = "browser" : "document" === g.auto_language && (e.auto_language = "document"), e.current_lang = ib(g.languages, g.current_lang), !Ua))
                if (t = JSON.parse(wa(e.cookie_name, "one", !0) || "{}"), K = void 0 !== t.level, C = void 0 !== t.data ? t.data : null, Z = "number" === typeof a.revision ? K ? -1 < a.revision ? t.revision === e.revision : !0 : !0 : !0, Q = !K || !Z, fb(), hb(a.theme_css, function () {
                        Wa();
                        db(a.gui_options);
                        Va();
                        e.autorun && Q && m.show(a.delay || 0);
                        setTimeout(function () {
                            J(L, "c--anim")
                        }, 30);
                        setTimeout(function () {
                            jb()
                        }, 100)
                    }), K && Z) {
                    var b = "boolean" === typeof t.rfc_cookie;
                    if (!b || b && t.rfc_cookie !== e.use_rfc_cookie) t.rfc_cookie = e.use_rfc_cookie, Ra(e.cookie_name, JSON.stringify(t));
                    Ga = Pa(Qa());
                    Ba();
                    "function" === typeof pa && pa(t)
                } else "opt-out" === e.mode && Ba(Ia)
        };
        m.showSettings = function (a) {
            setTimeout(function () {
                J(ra, "show--settings");
                E.setAttribute("aria-hidden", "false");
                Ca = !0;
                setTimeout(function () {
                    na ?
                        Ja = document.activeElement : qa = document.activeElement;
                    0 !== ja.length && (ja[3] ? ja[3].focus() : ja[0].focus(), v = ja)
                }, 200)
            }, 0 < a ? a : 0)
        };
        var Ba = function (a) {
            if (e.page_scripts) {
                var b = document.querySelectorAll("script[" + e.script_selector + "]"),
                    c = e.page_scripts_order,
                    d = a || t.level || [],
                    f = function (l, q) {
                        if (q < l.length) {
                            var h = l[q],
                                n = h.getAttribute(e.script_selector);
                            if (-1 < H(d, n)) {
                                h.type = "text/javascript";
                                h.removeAttribute(e.script_selector);
                                (n = h.getAttribute("data-src")) && h.removeAttribute("data-src");
                                var p = k("script");
                                p.textContent = h.innerHTML;
                                (function (F, w) {
                                    for (var A = w.attributes, u = A.length, r = 0; r < u; r++) {
                                        var B = A[r].nodeName;
                                        F.setAttribute(B, w[B] || w.getAttribute(B))
                                    }
                                })(p, h);
                                n ? p.src = n : n = h.src;
                                n && (c ? p.readyState ? p.onreadystatechange = function () {
                                    if ("loaded" === p.readyState || "complete" === p.readyState) p.onreadystatechange = null, f(l, ++q)
                                } : p.onload = function () {
                                    p.onload = null;
                                    f(l, ++q)
                                } : n = !1);
                                h.parentNode.replaceChild(p, h);
                                if (n) return
                            }
                            f(l, ++q)
                        }
                    };
                f(b, 0)
            }
        };
        m.set = function (a, b) {
            switch (a) {
                case "data":
                    a = b.value;
                    var c = !1;
                    if ("update" ===
                        b.mode)
                        if (C = m.get("data"), (b = typeof C === typeof a) && "object" === typeof C) {
                            !C && (C = {});
                            for (var d in a) C[d] !== a[d] && (C[d] = a[d], c = !0)
                        } else !b && C || C === a || (C = a, c = !0);
                    else C = a, c = !0;
                    c && (t.data = C, Ra(e.cookie_name, JSON.stringify(t)));
                    return c;
                case "revision":
                    return d = b.value, a = b.prompt_consent, b = b.message, L && "number" === typeof d && t.revision !== d ? (Fa = !0, Sa = b, Z = !1, e.revision = d, !0 === a ? (La(g), db(g.gui_options, !0), Wa(), m.show()) : m.accept(), b = !0) : b = !1, b;
                default:
                    return !1
            }
        };
        m.get = function (a, b) {
            return JSON.parse(wa(b || e.cookie_name,
                "one", !0) || "{}")[a]
        };
        m.getConfig = function (a) {
            return e[a] || g[a]
        };
        var Qa = function () {
                Ha = t.level || [];
                Ta = I.filter(function (a) {
                    return -1 === H(Ha, a)
                });
                return {
                    accepted: Ha,
                    rejected: Ta
                }
            },
            Pa = function (a) {
                var b = "custom",
                    c = ya.filter(function (d) {
                        return !0 === d
                    }).length;
                a.accepted.length === I.length ? b = "all" : a.accepted.length === c && (b = "necessary");
                return b
            };
        m.getUserPreferences = function () {
            var a = Qa();
            return {
                accept_type: Pa(a),
                accepted_categories: a.accepted,
                rejected_categories: a.rejected
            }
        };
        m.loadScript = function (a, b, c) {
            var d =
                "function" === typeof b;
            if (document.querySelector('script[src="' + a + '"]')) d && b();
            else {
                var f = k("script");
                if (c && 0 < c.length)
                    for (var l = 0; l < c.length; ++l) c[l] && f.setAttribute(c[l].name, c[l].value);
                d && (f.readyState ? f.onreadystatechange = function () {
                    if ("loaded" === f.readyState || "complete" === f.readyState) f.onreadystatechange = null, b()
                } : f.onload = b);
                f.src = a;
                (document.head ? document.head : document.getElementsByTagName("head")[0]).appendChild(f)
            }
        };
        m.updateScripts = function () {
            Ba()
        };
        m.show = function (a) {
            Q && setTimeout(function () {
                J(ra,
                    "show--consent");
                x.setAttribute("aria-hidden", "false");
                na = !0;
                setTimeout(function () {
                    qa = document.activeElement;
                    v = Ka
                }, 200)
            }, 0 < a ? a : 0)
        };
        m.hide = function () {
            Q && (Oa(ra, "show--consent"), x.setAttribute("aria-hidden", "true"), na = !1, setTimeout(function () {
                qa.focus();
                v = null
            }, 200))
        };
        m.hideSettings = function () {
            Oa(ra, "show--settings");
            Ca = !1;
            E.setAttribute("aria-hidden", "true");
            setTimeout(function () {
                na ? (Ja && Ja.focus(), v = Ka) : (qa && qa.focus(), v = null);
                oa = !1
            }, 200)
        };
        m.accept = function (a, b) {
            a = a || void 0;
            var c = b || [];
            b = [];
            var d =
                function () {
                    for (var l = document.querySelectorAll(".c-tgl") || [], q = [], h = 0; h < l.length; h++) l[h].checked && q.push(l[h].value);
                    return q
                };
            if (a)
                if ("object" === typeof a && "number" === typeof a.length)
                    for (var f = 0; f < a.length; f++) - 1 !== H(I, a[f]) && b.push(a[f]);
                else "string" === typeof a && ("all" === a ? b = I.slice() : -1 !== H(I, a) && b.push(a));
            else b = d();
            if (1 <= c.length)
                for (f = 0; f < c.length; f++) b = b.filter(function (l) {
                    return l !== c[f]
                });
            for (f = 0; f < I.length; f++) !0 === ya[f] && -1 === H(b, I[f]) && b.push(I[f]);
            gb(b)
        };
        m.eraseCookies = function (a, b,
            c) {
            var d = [];
            c = c ? [c, "." + c] : [e.cookie_domain, "." + e.cookie_domain];
            if ("object" === typeof a && 0 < a.length)
                for (var f = 0; f < a.length; f++) this.validCookie(a[f]) && d.push(a[f]);
            else this.validCookie(a) && d.push(a);
            bb(d, b, c)
        };
        var Ra = function (a, b) {
                var c = e.cookie_expiration;
                "number" === typeof e.cookie_necessary_only_expiration && "necessary" === Ga && (c = e.cookie_necessary_only_expiration);
                b = e.use_rfc_cookie ? encodeURIComponent(b) : b;
                var d = new Date;
                d.setTime(d.getTime() + 864E5 * c);
                c = "; expires=" + d.toUTCString();
                a = a + "=" + (b || "") +
                    c + "; Path=" + e.cookie_path + ";";
                a += " SameSite=" + e.cookie_same_site + ";"; - 1 < window.location.hostname.indexOf(".") && (a += " Domain=" + e.cookie_domain + ";");
                "https:" === window.location.protocol && (a += " Secure;");
                document.cookie = a
            },
            wa = function (a, b, c) {
                var d;
                if ("one" === b) {
                    if ((d = (d = document.cookie.match("(^|;)\\s*" + a + "\\s*=\\s*([^;]+)")) ? c ? d.pop() : a : "") && a === e.cookie_name) {
                        try {
                            d = JSON.parse(d)
                        } catch (f) {
                            try {
                                d = JSON.parse(decodeURIComponent(d))
                            } catch (l) {
                                d = {}
                            }
                        }
                        d = JSON.stringify(d)
                    }
                } else if ("all" === b)
                    for (a = document.cookie.split(/;\s*/),
                        d = [], b = 0; b < a.length; b++) d.push(a[b].split("=")[0]);
                return d
            },
            bb = function (a, b, c) {
                b = b ? b : "/";
                for (var d = 0; d < a.length; d++)
                    for (var f = 0; f < c.length; f++) document.cookie = a[d] + "=; path=" + b + (-1 < c[f].indexOf(".") ? "; domain=" + c[f] : "") + "; Expires=Thu, 01 Jan 1970 00:00:01 GMT;"
            };
        m.validCookie = function (a) {
            return "" !== wa(a, "one", !0)
        };
        var z = function (a, b, c, d) {
                a.addEventListener ? !0 === d ? a.addEventListener(b, c, {
                    passive: !0
                }) : a.addEventListener(b, c, !1) : a.attachEvent("on" + b, c)
            },
            va = function (a) {
                if ("object" === typeof a) {
                    var b = [],
                        c = 0;
                    for (b[c++] in a);
                    return b
                }
            },
            J = function (a, b) {
                a.classList ? a.classList.add(b) : $a(a, b) || (a.className += " " + b)
            },
            Oa = function (a, b) {
                a.classList ? a.classList.remove(b) : a.className = a.className.replace(new RegExp("(\\s|^)" + b + "(\\s|$)"), " ")
            },
            $a = function (a, b) {
                return a.classList ? a.classList.contains(b) : !!a.className.match(new RegExp("(\\s|^)" + b + "(\\s|$)"))
            };
        return m
    };
    "function" !== typeof window.initCookieConsent && (window.initCookieConsent = kb)
})();
