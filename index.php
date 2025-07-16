<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<link rel="icon" type="image/svg+xml" href="/vite.svg" />
		<meta name="generator" content="Hostinger Horizons" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Hostinger Horizons - Bienvenido <?php echo htmlspecialchars($user['name']); ?></title>
		<script type="module" crossorigin src="/assets/index-9d08ff95.js"></script>
		<link rel="stylesheet" href="/assets/index-930814d1.css">
		<script type="module">
window.onerror = (message, source, lineno, colno, errorObj) => {
	const errorDetails = errorObj ? JSON.stringify({
		name: errorObj.name,
		message: errorObj.message,
		stack: errorObj.stack,
		source,
		lineno,
		colno,
	}) : null;
	

	window.parent.postMessage({
		type: 'horizons-runtime-error',
		message,
		error: errorDetails
	}, '*');
};
</script>
		<script type="module">
const observer = new MutationObserver((mutations) => {
	for (const mutation of mutations) {
		for (const addedNode of mutation.addedNodes) {
			if (
				addedNode.nodeType === Node.ELEMENT_NODE &&
				(
					addedNode.tagName?.toLowerCase() === 'vite-error-overlay' ||
					addedNode.classList?.contains('backdrop')
				)
			) {
				handleViteOverlay(addedNode);
			}
		}
	}
});

observer.observe(document.documentElement, {
	childList: true,
	subtree: true
});

function handleViteOverlay(node) {
	if (!node.shadowRoot) {
		return;
	}

	const backdrop = node.shadowRoot.querySelector('.backdrop');

	if (backdrop) {
		const overlayHtml = backdrop.outerHTML;
		const parser = new DOMParser();
		const doc = parser.parseFromString(overlayHtml, 'text/html');
		const messageBodyElement = doc.querySelector('.message-body');
		const fileElement = doc.querySelector('.file');
		const messageText = messageBodyElement ? messageBodyElement.textContent.trim() : '';
		const fileText = fileElement ? fileElement.textContent.trim() : '';
		const error = messageText + (fileText ? ' File:' + fileText : '');

		window.parent.postMessage({
			type: 'horizons-vite-error',
			error,
		}, '*');
	}
}
</script>
		<script type="module">
const originalConsoleError = console.error;
console.error = function(...args) {
	originalConsoleError.apply(console, args);

	let errorString = '';

	for (let i = 0; i < args.length; i++) {
		const arg = args[i];
		if (arg instanceof Error) {
			errorString = arg.stack || `${arg.name}: ${arg.message}`;
			break;
		}
	}

	if (!errorString) {
		errorString = args.map(arg => typeof arg === 'object' ? JSON.stringify(arg) : String(arg)).join(' ');
	}

	window.parent.postMessage({
		type: 'horizons-console-error',
		error: errorString
	}, '*');
};
</script>
		<script type="module">
const originalFetch = window.fetch;

window.fetch = function(...args) {
	const url = args[0] instanceof Request ? args[0].url : args[0];

	// Skip WebSocket URLs
	if (url.startsWith('ws:') || url.startsWith('wss:')) {
		return originalFetch.apply(this, args);
	}

	return originalFetch.apply(this, args)
		.then(async response => {
			const contentType = response.headers.get('Content-Type') || '';

			// Exclude HTML document responses
			const isDocumentResponse =
				contentType.includes('text/html') ||
				contentType.includes('application/xhtml+xml');

			if (!response.ok && !isDocumentResponse) {
					const responseClone = response.clone();
					const errorFromRes = await responseClone.text();
					const requestUrl = response.url;
					console.error(`Fetch error from ${requestUrl}: ${errorFromRes}`);
			}

			return response;
		})
		.catch(error => {
			if (!url.match(/.html?$/i)) {
				console.error(error);
			}

			throw error;
		});
};
</script>
	</head>
	<body>
		<div id="root"></div>
		<nav style="background: #f8f9fa; padding: 10px; border-bottom: 1px solid #dee2e6; margin-bottom: 20px;">
			<div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
				<div>
					<span style="color: #495057; font-weight: 500;">Bienvenido, <?php echo htmlspecialchars($user['name']); ?></span>
					<span style="color: #6c757d; margin-left: 10px;">(<?php echo htmlspecialchars($user['email']); ?>)</span>
				</div>
				<div>
					<a href="register.php" style="color: #007bff; text-decoration: none; margin-right: 15px;">Registrar nuevo usuario</a>
					<a href="logout.php" style="color: #dc3545; text-decoration: none; font-weight: 500;">Cerrar sesión</a>
				</div>
			</div>
		</nav>
	</body>
</html>

