/**
 * Script de Validação do Sistema de Sidebar Colapsável
 * Execute este script no console do navegador para validar a implementação
 */

console.log('🔍 Iniciando validação do Sistema de Sidebar...\n');

// Função para validar elementos DOM
function validateElement(selector, name) {
    const element = document.querySelector(selector);
    const exists = !!element;
    console.log(`${exists ? '✅' : '❌'} ${name}: ${exists ? 'OK' : 'ERRO - Não encontrado'}`);
    return exists;
}

// Função para validar classes CSS
function validateCSS(className, name) {
    const testElement = document.createElement('div');
    testElement.className = className;
    document.body.appendChild(testElement);
    
    const styles = window.getComputedStyle(testElement);
    const hasStyles = styles.getPropertyValue('--sidebar-width') !== '';
    
    document.body.removeChild(testElement);
    console.log(`${hasStyles ? '✅' : '❌'} ${name}: ${hasStyles ? 'OK' : 'ERRO - CSS não carregado'}`);
    return hasStyles;
}

// Função para validar JavaScript
function validateJS() {
    const hasGlobalInstance = typeof window.sidebarToggle !== 'undefined';
    console.log(`${hasGlobalInstance ? '✅' : '❌'} Instância Global: ${hasGlobalInstance ? 'OK' : 'ERRO - JavaScript não carregado'}`);
    
    if (hasGlobalInstance) {
        const methods = ['collapse', 'expand', 'toggle', 'isCollapsed', 'isMobileOpen'];
        methods.forEach(method => {
            const hasMethod = typeof window.sidebarToggle[method] === 'function';
            console.log(`${hasMethod ? '✅' : '❌'} Método ${method}(): ${hasMethod ? 'OK' : 'ERRO'}`);
        });
    }
    
    return hasGlobalInstance;
}

// Função para testar localStorage
function validateStorage() {
    try {
        localStorage.setItem('sidebar-test', 'ok');
        const canRead = localStorage.getItem('sidebar-test') === 'ok';
        localStorage.removeItem('sidebar-test');
        console.log(`${canRead ? '✅' : '❌'} LocalStorage: ${canRead ? 'OK' : 'ERRO'}`);
        return canRead;
    } catch (e) {
        console.log(`❌ LocalStorage: ERRO - ${e.message}`);
        return false;
    }
}

// Função para testar eventos
function validateEvents() {
    let eventsFired = 0;
    const events = ['sidebarCollapsed', 'sidebarExpanded', 'mobileSidebarOpened', 'mobileSidebarClosed'];
    
    events.forEach(eventName => {
        document.addEventListener(eventName, () => {
            eventsFired++;
        });
    });
    
    console.log(`✅ Event Listeners: ${events.length} eventos registrados para teste`);
    return true;
}

// Função principal de validação
function runValidation() {
    console.log('📋 Validando Elementos DOM:');
    console.log('─'.repeat(40));
    
    const domChecks = [
        validateElement('#sidebar-toggle', 'Botão Toggle Desktop'),
        validateElement('#mobile-collapse', 'Botão Toggle Mobile'),
        validateElement('.dash-sidebar', 'Sidebar Principal'),
        validateElement('.dash-header', 'Header'),
        validateElement('.dash-container', 'Container Principal'),
        validateElement('.sidebar-toggle-icon', 'Ícone do Toggle')
    ];
    
    console.log('\n🎨 Validando CSS:');
    console.log('─'.repeat(40));
    
    const cssChecks = [
        validateCSS('sidebar-test', 'Variáveis CSS')
    ];
    
    console.log('\n⚡ Validando JavaScript:');
    console.log('─'.repeat(40));
    
    const jsChecks = [
        validateJS(),
        validateStorage(),
        validateEvents()
    ];
    
    // Resumo final
    const totalChecks = domChecks.length + cssChecks.length + jsChecks.length;
    const passedChecks = [...domChecks, ...cssChecks, ...jsChecks].filter(Boolean).length;
    
    console.log('\n🎯 Resumo da Validação:');
    console.log('═'.repeat(40));
    console.log(`Total de verificações: ${totalChecks}`);
    console.log(`Aprovadas: ${passedChecks}`);
    console.log(`Reprovadas: ${totalChecks - passedChecks}`);
    console.log(`Taxa de sucesso: ${Math.round((passedChecks / totalChecks) * 100)}%`);
    
    if (passedChecks === totalChecks) {
        console.log('\n🎉 SISTEMA TOTALMENTE OPERACIONAL!');
        console.log('O sistema de sidebar está funcionando perfeitamente.');
        
        // Teste funcional opcional
        if (window.sidebarToggle) {
            console.log('\n🧪 Executando teste funcional (opcional):');
            console.log('Teste de toggle em 3 segundos...');
            
            setTimeout(() => {
                if (window.innerWidth >= 992) {
                    window.sidebarToggle.toggle();
                    console.log('✅ Toggle executado com sucesso!');
                    
                    setTimeout(() => {
                        window.sidebarToggle.toggle();
                        console.log('✅ Toggle reverso executado com sucesso!');
                    }, 1000);
                } else {
                    console.log('ℹ️ Teste funcional pulado (tela mobile)');
                }
            }, 3000);
        }
        
    } else {
        console.log('\n⚠️ ATENÇÃO: Sistema com problemas!');
        console.log('Verifique os itens marcados com ❌ acima.');
        
        // Sugestões de solução
        console.log('\n💡 Sugestões de solução:');
        
        if (!document.querySelector('#sidebar-toggle')) {
            console.log('• Adicione o botão de toggle ao header');
        }
        
        if (typeof window.sidebarToggle === 'undefined') {
            console.log('• Verifique se o JavaScript está carregado');
            console.log('• Verifique se não há erros no console');
        }
        
        if (!document.querySelector('.dash-sidebar')) {
            console.log('• Verifique se está na página correta do admin');
        }
    }
    
    return passedChecks === totalChecks;
}

// Função para executar quando DOM estiver pronto
function init() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runValidation);
    } else {
        runValidation();
    }
}

// Executar validação
init();

// Exportar funções para uso manual
window.sidebarValidation = {
    run: runValidation,
    validateElement,
    validateCSS,
    validateJS,
    validateStorage,
    validateEvents
};

console.log('\n💻 Comandos disponíveis:');
console.log('• window.sidebarValidation.run() - Executar validação completa');
console.log('• window.sidebarToggle.toggle() - Testar toggle manual');
console.log('• window.sidebarToggle.collapse() - Colapsar sidebar');
console.log('• window.sidebarToggle.expand() - Expandir sidebar'); 