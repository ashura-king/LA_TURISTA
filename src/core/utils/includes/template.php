<script>
    window.addEventListener('DOMContentLoaded', () => {

        class <?= $capitalized ?> extends HTMLElement {
            constructor() {
                super();

                <?= $js ?>
                this.innerHTML = `<?= $contents ?>`;

                const pattern = /{{ \$.* }}/g;
                const matches = [...this.innerHTML.matchAll(pattern)];

                let toText = String(this.innerHTML);

                matches.forEach(match => {
                    const variable = String(match[0])
                        .replace("{{", "")
                        .replace("}}", "")
                        .replace("$", "")
                        .trim()

                    eval(`toText = toText.replace(match[0], ${variable});`);
                })

                this.innerHTML = toText;
            }
        }

        customElements.define('x-<?= $lowered ?>', <?= $capitalized ?>);

    });
</script>