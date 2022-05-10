const Ziggy = {"url":"http:\/\/ip-tools-v2.test","port":null,"defaults":{},"routes":{"ip.show":{"uri":"api\/ip","methods":["POST"]},"ip.advanced.show":{"uri":"api\/ip\/advanced","methods":["POST"]},"home.index":{"uri":"\/","methods":["GET","HEAD"]},"auth.login.store":{"uri":"login","methods":["POST"]},"auth.login.create":{"uri":"login","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
