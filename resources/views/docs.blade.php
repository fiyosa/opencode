<!doctype html>
<html>

<head>
  <title>API Documentation</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
  <div id="app"></div>
  <script src="/vendor/scalar/scalar-api-reference.js"></script>
  <script>
    Scalar.createApiReference('#app', {
      url: '/docs/openapi.json',
      agent: { disabled: true },
      layout: "modern",
      mcp: { disabled: true },
      hideClientButton: true,
      telemetry: false,
      theme: "solarized",
      defaultOpenAllTags: false,
      defaultOpenFirstTag: false,
      showDeveloperTools: "never",
    })
  </script>
</body>

</html>